# Laravel Message
## 项目介绍
本项目旨在解决站内私信问题。仅支持用户一对一的私信发送，不支持群组。

## 功能介绍
1. 私信发送
2. 私信删除
3. 私信提醒
4. 未读统计
> 当用户发送时，自动创建提醒。
> 当阅读私信时，自定完成将提醒设置已读。

## 安装
```command
composer require happyphper/laravel-message
```

## 发布文件
```command
php artisan vendor:publish
```
生成 migration 数据库迁移文件以及 laravel-message.php 配置文件。

## 数据库迁移
```command
php artisan migrate
```

## 配置
你可以修改配置信息和迁移文件。比如你需要将 `user_id` 字段设置为 uuid 类型，你可以修改迁移文件为 `user_id` 字段类型为 char(36) 。
针对自己的需要进行修改即可。

## 注册事件监听
你需要在 `app\Providers\EventServiceProvider` 在 `$listen` 数组中添加监听项，此操作关乎提醒的生成及设置提醒已读。

```php
protected $listen = [
    ...
    'Happyphper\LaravelMessage\Events\NewMessageEvent' => [
        'Happyphper\LaravelMessage\Listeners\NewMessageListener',
        'Happyphper\LaravelMessage\Listeners\LastMessageListener',
    ],
    'Happyphper\LaravelMessage\Events\ReadMessageEvent' => [
        'Happyphper\LaravelMessage\Listeners\ReadMessageListener'
    ]
    ...
];
```

## 方法
```php
// 获取会话
Happyphper\LaravelMessage\Chat::getConversationBetweenUsers($userId, $opponentId)
// 发送私信
Happyphper\LaravelMessage\Chat::send($senderId, $recipientId, $body, $type = 'text')
// 未读私信数
Happyphper\LaravelMessage\Chat::unread($userId)
// 删除会话
Happyphper\LaravelMessage\Chat::deleteConversation($conversation)
// 删除私信
Happyphper\LaravelMessage\Chat::deleteMessage($conversation, $message)
```

## 示例
```php
// 发送私信
public function store(Request $request)
{
    // 模拟登陆
    auth()->loginUsingId(1);
    // 发送私信
    list($message, $opponentMessage) = Chat::send(auth()->id(), $request->opponent_id, $request->body, $request->type);
    // 触发新私信事件
    event(new  NewMessageEvent($message, $opponentMessage));

    return $message;
}

// 读取私信
public function index(Conversation $conversation)
{
    $messages = $conversation->messages()->latest()->paginate();
    // 触发读私信事件
    event(new ReadMessageEvent($conversation));

    return $messages;
}

// 删除会话
public function destroy(Conversation $conversation)
{
    Chat::deleteConversation($conversation);

    return response(null, 204);
}

// 删除私信
public function destroy(Conversation $conversation, $message)
{
    $message = $conversation->messages()->findOrFail($message);

    Chat::deleteMessage($conversation, $message);

    return response(null, 204);
}
```
