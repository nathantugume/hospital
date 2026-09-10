<?php

return [
    'africas_talking' => [
        'username' => env('AFRICAS_TALKING_USERNAME', 'sandbox'),
        'api_key' => env('AFRICAS_TALKING_API_KEY'),
        'sender_id' => env('AFRICAS_TALKING_SENDER_ID', 'MEDITRACK'),
        'shortcode' => env('AFRICAS_TALKING_SHORTCODE'),
        'sandbox' => env('AFRICAS_TALKING_SANDBOX', true),
        'base_url' => env('AFRICAS_TALKING_BASE_URL', 'https://api.africastalking.com/version1'),
        'voice_base_url' => env('AFRICAS_TALKING_VOICE_BASE_URL', 'https://voice.africastalking.com'),
    ],
    'mtn_momo' => [
        'api_user' => env('MTN_MOMO_API_USER'),
        'api_key' => env('MTN_MOMO_API_KEY'),
        'subscription_key' => env('MTN_MOMO_SUBSCRIPTION_KEY'),
        'environment' => env('MTN_MOMO_ENVIRONMENT', 'sandbox'),
        'target_environment' => env('MTN_MOMO_TARGET_ENVIRONMENT', 'mtncameroon'),
        'collection_primary' => env('MTN_MOMO_COLLECTION_PRIMARY'),
        'disbursement_primary' => env('MTN_MOMO_DISBURSEMENT_PRIMARY'),
        'callback_url' => env('MTN_MOMO_CALLBACK_URL'),
        'base_url' => env('MTN_MOMO_BASE_URL', 'https://sandbox.momodeveloper.mtn.com'),
    ],
    'airtel_money' => [
        'client_id' => env('AIRTEL_MONEY_CLIENT_ID'),
        'client_secret' => env('AIRTEL_MONEY_CLIENT_SECRET'),
        'grant_type' => env('AIRTEL_MONEY_GRANT_TYPE', 'client_credentials'),
        'environment' => env('AIRTEL_MONEY_ENVIRONMENT', 'sandbox'),
        'callback_url' => env('AIRTEL_MONEY_CALLBACK_URL'),
        'base_url' => env('AIRTEL_MONEY_BASE_URL', 'https://openapiuat.airtel.africa'),
    ],
    'mpesa' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'passkey' => env('MPESA_PASSKEY'),
        'shortcode' => env('MPESA_SHORTCODE'),
        'environment' => env('MPESA_ENVIRONMENT', 'sandbox'),
        'callback_url' => env('MPESA_CALLBACK_URL'),
        'base_url' => env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'),
    ],
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
        'emergency_group' => env('TWILIO_EMERGENCY_GROUP'),
    ],
    'nira' => [
        'api_url' => env('NIRA_API_URL'),
        'api_key' => env('NIRA_API_KEY'),
        'client_id' => env('NIRA_CLIENT_ID'),
        'client_secret' => env('NIRA_CLIENT_SECRET'),
        'timeout' => env('NIRA_TIMEOUT', 30),
    ],
    'niims' => [
        'api_url' => env('NIIMS_API_URL'),
        'api_key' => env('NIIMS_API_KEY'),
    ],
    'nida' => [
        'api_url' => env('NIDA_API_URL'),
        'api_key' => env('NIDA_API_KEY'),
    ],
    'nida_rwanda' => [
        'api_url' => env('NIDA_RWANDA_API_URL'),
        'api_key' => env('NIDA_RWANDA_API_KEY'),
    ],
    'insurance' => [
        'providers' => [
            'uap' => [
                'url' => env('INSURANCE_UAP_API_URL'),
                'key' => env('INSURANCE_UAP_API_KEY'),
            ],
            'jubilee' => [
                'url' => env('INSURANCE_JUBILEE_API_URL'),
                'key' => env('INSURANCE_JUBILEE_API_KEY'),
            ],
            'icea' => [
                'url' => env('INSURANCE_ICEA_API_URL'),
                'key' => env('INSURANCE_ICEA_API_KEY'),
            ],
            'britam' => [
                'url' => env('INSURANCE_BRITAM_API_URL'),
                'key' => env('INSURANCE_BRITAM_API_KEY'),
            ],
            'sanlam' => [
                'url' => env('INSURANCE_SANLAM_API_URL'),
                'key' => env('INSURANCE_SANLAM_API_KEY'),
            ],
            'nhif_kenya' => [
                'url' => env('NHIF_KENYA_API_URL'),
                'key' => env('NHIF_KENYA_API_KEY'),
            ],
            'nhif_tanzania' => [
                'url' => env('NHIF_TANZANIA_API_URL'),
                'key' => env('NHIF_TANZANIA_API_KEY'),
            ],
            'rssb_rwanda' => [
                'url' => env('RSSB_RWANDA_API_URL'),
                'key' => env('RSSB_RWANDA_API_KEY'),
            ],
        ],
    ],
    'nms' => [
        'api_url' => env('NMS_API_URL'),
        'api_key' => env('NMS_API_KEY'),
        'account_number' => env('NMS_ACCOUNT_NUMBER'),
    ],
    'kemsa' => [
        'api_url' => env('KEMSA_API_URL'),
        'api_key' => env('KEMSA_API_KEY'),
    ],
    'msd' => [
        'api_url' => env('MSD_API_URL'),
        'api_key' => env('MSD_API_KEY'),
    ],
    'lis' => [
        'api_url' => env('LIS_API_URL'),
        'api_key' => env('LIS_API_KEY'),
        'hl7_port' => env('LIS_HL7_PORT', 2575),
        'fhir_base' => env('LIS_FHIR_BASE'),
    ],
    'gps' => [
        'provider' => env('GPS_PROVIDER', 'ontrack'),
        'api_url' => env('GPS_API_URL'),
        'api_key' => env('GPS_API_KEY'),
        'poll_interval' => env('GPS_POLL_INTERVAL', 30),
    ],
    'feature_flags' => [
        'enable_2fa' => env('ENABLE_2FA', true),
        'enable_email_verification' => env('ENABLE_EMAIL_VERIFICATION', true),
        'enable_sms_notifications' => env('ENABLE_SMS_NOTIFICATIONS', true),
        'enable_mobile_money' => env('ENABLE_MOBILE_MONEY', true),
        'enable_insurance_integration' => env('ENABLE_INSURANCE_INTEGRATION', true),
        'enable_id_verification' => env('ENABLE_ID_VERIFICATION', true),
        'enable_lis_integration' => env('ENABLE_LIS_INTEGRATION', true),
        'enable_pharmacy_supply_chain' => env('ENABLE_PHARMACY_SUPPLY_CHAIN', true),
        'enable_ambulance_gps' => env('ENABLE_AMBULANCE_GPS', true),
        'enable_twilio_emergency' => env('ENABLE_TWILIO_EMERGENCY', true),
    ],
    'pii_encryption_key' => env('PII_ENCRYPTION_KEY'),
];
