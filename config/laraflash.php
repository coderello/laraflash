<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Single Message Skin
    |--------------------------------------------------------------------------
    |
    | This value is the skin of the single message.
    |
    | Here are some pre-defined skins, which you can use.
    |
    | Styling using Tailwind:
    | - 'laraflash_skin::tailwind.banner'
    | - 'laraflash_skin::tailwind.left_accent_border'
    | - 'laraflash_skin::tailwind.solid'
    | - 'laraflash_skin::tailwind.titled'
    | - 'laraflash_skin::tailwind.top_accent_border'
    | - 'laraflash_skin::tailwind.traditional'
    |
    | Styling using Bootstrap:
    | - 'laraflash_skin::bootstrap.basic'
    | - 'laraflash_skin::bootstrap.titled'
    | - 'laraflash_skin::bootstrap.traditional'
    |
    */
    'skin' => 'laraflash_skin::tailwind.left_accent_border',

    /*
    |--------------------------------------------------------------------------
    | Separator Between The Flash Messages
    |--------------------------------------------------------------------------
    |
    | This value is the separator between the flash messages.
    |
    */
    'separator' => '<br>',

    /*
    |--------------------------------------------------------------------------
    | Messages Storage
    |--------------------------------------------------------------------------
    |
    | Drivers: "session", "array"
    |
    */
    'messages_storage' => 'session',

];
