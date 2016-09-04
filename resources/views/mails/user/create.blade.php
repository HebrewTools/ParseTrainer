Dear {{ $user->name }},

Thank you for creating an account at the Hebrew Parse Trainer.

You can now login at {{ URL::to('/admin') }}, using your email address and password.

If you need any help, you can reach us at {{ env('MAIL_FROM_ADDRESS') }}.

Thank you for your help!

Best,

{{ env('MAIL_FROM_NAME') }}
