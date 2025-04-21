<?php

dataset('invalidRegisters', function () {
    return [
        [[
            'name' => 'كلام طووووووووووووووووووووووووووووووووووووييييييييييييييييييييييييل اكثر من 45 حرف',
            'email' => 'Ahmed@email.com',
            'password' => '12(Mn)34',
        ]],
        [[
            'name' => 'احمد',
            'email' => 'Ahmedemail.com',
            'password' => '12(Mn)34',
            'password_confirmation' => '12(Mn)34',
        ]],

    ];
});
