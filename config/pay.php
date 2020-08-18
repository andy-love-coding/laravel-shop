<?php

return [
    'alipay' => [
        'app_id'          => '2021000120609676',
        'ali_public_key'  => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApTa5tgpgddeHAQaSECK40EqsKxsgQ/MjxbQmFZ6WF9CeKVE9Id4vMtVyHi/fao3Iq6nn+ZT1u0Zet24d07DIcjVwBclyKqO723Ht8/LBOOZkMVaEj1/uLzH5WcT+JdPU/w+QOdOnbqNow74GiNTwG0randTp3GiGWNWeDxlFSQFFK0KBeEWn/CAFSwe4F7OnW/kTddvI3C6jdOOtjmeP56zSaob0jMbO5yi9hGGhpGwHsqfwJdedkr5h4mWZhC8lZoyNBoTaBC1FyKNGRhlgiANiMPtpQHN5lQ6jkv71F0lQqi6+u43I4g5T5o5mV2jSWnVvp8GghYMGz8ZAbis6xQIDAQAB',
        'private_key'     => 'MIIEpAIBAAKCAQEApTa5tgpgddeHAQaSECK40EqsKxsgQ/MjxbQmFZ6WF9CeKVE9Id4vMtVyHi/fao3Iq6nn+ZT1u0Zet24d07DIcjVwBclyKqO723Ht8/LBOOZkMVaEj1/uLzH5WcT+JdPU/w+QOdOnbqNow74GiNTwG0randTp3GiGWNWeDxlFSQFFK0KBeEWn/CAFSwe4F7OnW/kTddvI3C6jdOOtjmeP56zSaob0jMbO5yi9hGGhpGwHsqfwJdedkr5h4mWZhC8lZoyNBoTaBC1FyKNGRhlgiANiMPtpQHN5lQ6jkv71F0lQqi6+u43I4g5T5o5mV2jSWnVvp8GghYMGz8ZAbis6xQIDAQABAoIBAQCAUKSj8iNA4wgDj+rZhV4syBI32HWS0MAzyNrbZ7QDAxAT3viv2TSnMofTUjMfOsdkLC3y9fJ0ZQ8jP+8CfwbvTPmYRQDahRheM3owQZY4bxfaCewivsrq9NFJG2qYTpHbF2dYwj4D+/5eKLRCib+CMvzgIIERokzVqfN8no/lRkm6N1EeXLhKVACLWO9nMVULVfoK/QVxG69iLY8zJI2nm+AAKupPgYaXgIh3bdDt588CHCu5n/aPU2pNItJfGuHfUulG2tPiJ4B3apr5LxXVbQHxxH3ZiTB2A5QdCDnDlw8zQbmQpKKL8e6Ss97PfzuGXPX0axOeH10gDvIA1iHxAoGBAOaTyMR1bLZ/pVU7LQBl1ZeJhASuw06aDwzYjCKSTPBzzl/SNnJAZ1BQ5V9J+S8YekfLr/FWNYJyD7vnKorCNsH1dPv+mds53Li+BYO9YfdLqzrFqAhhkwTW6Daj4ba3xcG5hfrAnUr47DKByVAQ31fApB7fAA36CULmOm/oJGCfAoGBALduAeEdQMIiMFFPW+u9NdCWl2RatIegP9CPmkRY7dtISTHvl18uMnCj3gOtgtH3l2VIGhsl652iy3LwhbeyrKPEhFdDfIjLQ2aaBWpRdl/6mt43aMkmyGzcTn1Y30lg5dxC9PKkTP93hnc7weFy/L05Jhc4UyAHIBA+D53T3LYbAoGAUHhTIP06K5bwxIYadoETwgckI946Gzx49Cq+/XHBmElSRO7AQa9oXwdchZzzchRA2L2lcbx8gEH+a72Jg1O0eIyJf0ijuXbAKVln40o83mlyINjKg+JJxO6brDYVmAca5TkyIQkH3BpzlEznTSIWUDHTFVMOWdJhWQ+wZU3HJFECgYAMurGesa0Ay+aWfe9fGK5XX1v6NuE4WEKVcqG+BH3dLdMGiB31GPufHYAWuT/O2mPDP5GwOJ11PwrnWxGsgdXBN64HcEOAKrrur9mYWzbfykBdE3NOIkbeZxt7T2OPcA4DjxH4lLZTNDQ8qgT2ZEhtyT1/dwUtv9DVz7i9tyol6QKBgQC9wkl5EY8+jPMFk2UjnfwuB2HaN2evgLqsca1ITo3WReVpXPTqYiP+cVjwyGRzwakQ/PGjkiat7j1cpUOKEkuobP+lGSuPCX0vVyeNgP/cFo8YBfdCZgkm3r2W9a4Q1rL4JOxnWtc4ynyHeo4HOCKNAVfIeyEbRzh9uagAxZG1WA==',
        'log'             => [
            'file'  => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat'  => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file'  => storage_path('logs/wechat_pay.log'),
        ],
    ]
];