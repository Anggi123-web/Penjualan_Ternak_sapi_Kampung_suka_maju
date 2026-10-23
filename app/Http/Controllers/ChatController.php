<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Sapi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Ambil riwayat percakapan antara user saat ini dan lawan bicara
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'transaksi_id' => 'nullable|exists:transaksis,id',
            'sapi_id' => 'nullable|exists:sapis,id',
        ]);

        $currentUserId = Auth::id();
        $otherUserId = (int) $request->user_id;

        $otherUser = User::findOrFail($otherUserId);

        // Tandai pesan masuk dari user tersebut sebagai terbaca
        Chat::where('pengirim_id', $otherUserId)
            ->where('penerima_id', $currentUserId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        // Ambil semua pesan percakapan
        $messages = Chat::betweenUsers($currentUserId, $otherUserId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) use ($currentUserId) {
                return [
                    'id' => $chat->id,
                    'pesan' => $chat->pesan,
                    'is_me' => $chat->pengirim_id === $currentUserId,
                    'waktu' => $chat->waktu_formatted,
                    'is_read' => $chat->is_read,
                    'transaksi_id' => $chat->transaksi_id,
                    'sapi_id' => $chat->sapi_id,
                ];
            });

        // Ambil data referensi transaksi / sapi jika ada
        $reference = null;
        if ($request->filled('transaksi_id')) {
            $trx = Transaksi::with('sapi')->find($request->transaksi_id);
            if ($trx) {
                $fotoUrl = asset('images/default_sapi.jpg');
                if ($trx->sapi && !empty($trx->sapi->foto)) {
                    $fotos = is_array($trx->sapi->foto) ? $trx->sapi->foto : json_decode($trx->sapi->foto, true);
                    if (!empty($fotos[0])) {
                        $fotoUrl = asset('storage/' . $fotos[0]);
                    }
                }
                $reference = [
                    'type' => 'transaksi',
                    'title' => 'Pesanan: ' . $trx->kode_transaksi,
                    'subtitle' => 'Sapi ' . ($trx->sapi->jenis ?? 'Ternak') . ' &bull; Rp ' . number_format($trx->total_harga, 0, ',', '.'),
                    'image' => $fotoUrl,
                ];
            }
        } elseif ($request->filled('sapi_id')) {
            $sapi = Sapi::find($request->sapi_id);
            if ($sapi) {
                $fotoUrl = asset('images/default_sapi.jpg');
                if (!empty($sapi->foto)) {
                    $fotos = is_array($sapi->foto) ? $sapi->foto : json_decode($sapi->foto, true);
                    if (!empty($fotos[0])) {
                        $fotoUrl = asset('storage/' . $fotos[0]);
                    }
                }
                $reference = [
                    'type' => 'sapi',
                    'title' => 'Sapi ' . $sapi->jenis,
                    'subtitle' => 'Bobot ' . $sapi->bobot . ' kg &bull; Rp ' . number_format($sapi->harga, 0, ',', '.'),
                    'image' => $fotoUrl,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'other_user' => [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'role' => ucfirst($otherUser->role),
                'role_raw' => $otherUser->role,
                'initials' => strtoupper(substr($otherUser->name, 0, 2)),
                'phone' => $otherUser->no_telepon,
            ],
            'messages' => $messages,
            'reference' => $reference,
        ]);
    }

    /**
     * Kirim pesan baru
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'pesan' => 'required|string|max:2000',
            'transaksi_id' => 'nullable|exists:transaksis,id',
            'sapi_id' => 'nullable|exists:sapis,id',
        ], [
            'pesan.required' => 'Pesan tidak boleh kosong.',
        ]);

        $currentUserId = Auth::id();
        $penerimaId = (int) $request->penerima_id;

        if ($currentUserId === $penerimaId) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengirim pesan ke diri sendiri.',
            ], 422);
        }

        $chat = Chat::create([
            'pengirim_id' => $currentUserId,
            'penerima_id' => $penerimaId,
            'transaksi_id' => $request->transaksi_id,
            'sapi_id' => $request->sapi_id,
            'pesan' => trim($request->pesan),
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'pesan' => $chat->pesan,
                'is_me' => true,
                'waktu' => $chat->waktu_formatted,
                'is_read' => false,
                'transaksi_id' => $chat->transaksi_id,
                'sapi_id' => $chat->sapi_id,
            ],
        ]);
    }

    /**
     * Ambil jumlah pesan belum terbaca untuk user saat ini
     */
    public function getUnreadCount()
    {
        $count = Chat::where('penerima_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $count,
        ]);
    }

    /**
     * Ambil daftar kontak/percakapan terakhir
     */
    public function getConversations()
    {
        $userId = Auth::id();

        // Ambil semua pesan yang melibatkan user saat ini
        $chats = Chat::with(['pengirim', 'penerima'])
            ->where('pengirim_id', $userId)
            ->orWhere('penerima_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $partnerIds = [];
        $conversations = [];

        foreach ($chats as $chat) {
            $partnerId = $chat->pengirim_id === $userId ? $chat->penerima_id : $chat->pengirim_id;
            if (!in_array($partnerId, $partnerIds)) {
                $partnerIds[] = $partnerId;
                $partner = $chat->pengirim_id === $userId ? $chat->penerima : $chat->pengirim;
                
                if ($partner) {
                    $unread = Chat::where('pengirim_id', $partnerId)
                        ->where('penerima_id', $userId)
                        ->where('is_read', false)
                        ->count();

                    $conversations[] = [
                        'partner_id' => $partner->id,
                        'name' => $partner->name,
                        'role' => ucfirst($partner->role),
                        'role_raw' => $partner->role,
                        'initials' => strtoupper(substr($partner->name, 0, 2)),
                        'last_message' => $chat->pesan,
                        'last_time' => $chat->waktu_formatted,
                        'unread' => $unread,
                        'transaksi_id' => $chat->transaksi_id,
                        'sapi_id' => $chat->sapi_id,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }
}
