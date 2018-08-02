<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Model Name
    |--------------------------------------------------------------------------
    |
    | This value will be used by migration and Model's relationship
    |
    */

    'user_model' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | User Model Primary Key
    |--------------------------------------------------------------------------
    |
    | This value will be used by migration and Model's relationship
    |
    */

    'user_id' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Conversation Table Name
    |--------------------------------------------------------------------------
    |
    | This value will be used by migration and Model's relationship
    |
    */

    'conversation_table' => 'conversations',

    /*
    |--------------------------------------------------------------------------
    | Message Table Name
    |--------------------------------------------------------------------------
    |
    | This value will be used by migration and Model's relationship
    |
    */

    'message_table' => 'messages',

    /*
    |--------------------------------------------------------------------------
    | Message Notification Table Name
    |--------------------------------------------------------------------------
    |
    | This value will be used by migration and Model's relationship
    |
    */

    'message_notification_table' => 'message_notifications',
];