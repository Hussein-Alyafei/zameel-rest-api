<?php

dataset('vaildRegisters', function () {
    return [
        [[

            'name' => 'أحمد',
            'email' => 'Ahmed@email.com',
            'password' => '12(Mn)Up',
            'password_confirmation' => '12(Mn)Up',

        ]],
        [[

            'name' => 'أحمد',
            'email' => 'Ahmed@email.com',
            'password' => '12(Mn)34',
            'password_confirmation' => '12(Mn)34',
        ]],
    ];
});
