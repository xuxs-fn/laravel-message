<?php

namespace Happyphper\LaravelMessage;

use Happyphper\LaravelMessage\Models\Conversation;
use Happyphper\LaravelMessage\Models\Message;
use Happyphper\LaravelMessage\Models\MessageNotification;
use Illuminate\Support\Facades\DB;

class Chat
{
    /**
     * 通过用户获取会话
     *
     * @param int $userId
     * @param int $opponentId
     * @return Conversation|null
     */
    public static function getConversationBetweenUsers($userId, $opponentId)
    {
        return Conversation::where('user_id', $userId)->where('opponent_id', $opponentId)->first();
    }

    /**
     * 发送消息
     *
     * @param $senderId
     * @param $recipientId
     * @param $body
     * @param string $type
     * @return array
     * @throws \Exception
     */
    public static function send($senderId, $recipientId, $body, $type = 'text')
    {
        // 当会话不存在即添加，否则不做修改
        // 两个用户之间的私信包含两个会话，其中 user_id 标识为哪一个用户的会话，允许对本次会话进行删除等操作，这种操作不影响对方会话中的数据。
        return DB::transaction(function () use ($senderId, $recipientId, $body, $type) {
            $senderConversation = Conversation::firstOrCreate(['user_id' => $senderId, 'opponent_id' => $recipientId]);

            $recipientConversation = Conversation::firstOrCreate(['user_id' => $recipientId, 'opponent_id' => $senderId]);

            $message = $senderConversation->messages()->create([
                'sender_id'=> $senderId,
                'recipient_id' => $recipientId,
                'body' => $body,
                'type' => $type
            ]);

            $opponentMessage = $recipientConversation->messages()->create([
                'sender_id'=> $senderId,
                'recipient_id' => $recipientId,
                'body' => $body,
                'type' => $type
            ]);

            return [$message, $opponentMessage];
        });
    }

    /**
     * 未读消息数
     *
     * @param $userId
     * @return integer
     */
    public static function unread($userId)
    {
        return MessageNotification::where('user_id', $userId)->where('is_seen', 0)->count();
    }

    /**
     * 删除会话
     *
     * @param Conversation $conversation
     * @return void
     */
    public static function deleteConversation(Conversation $conversation)
    {
        DB::transaction(function() use ($conversation) {
            // 清空消息
            $conversation->messages()->delete();
            // 清除提醒
            $conversation->notifications()->delete();
            // 删除会话
            $conversation->delete();
        });
    }

    /**
     * 删除私信
     *
     * @param Conversation $conversation
     * @param Message $message
     * @return void
     * @throws \Exception
     */
    public static function deleteMessage(Conversation $conversation, Message $message)
    {
        if ($conversation->last_message_id != $message->id) {
            $message->delete();
        } else {
            // 查询倒数第二条消息ID
            $lastMessage = $conversation->messages()->latest()->offset(1)->take(1)->first();

            DB::transaction(function () use ($conversation, $lastMessage, $message) {
                $conversation->last_message_id = $lastMessage->id;
                $conversation->save();
                $message->delete();
            });
        }
    }
}