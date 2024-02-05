<?php

return [

    // All the sections for the settings page
    'sections' => [
        'app' => [
            'title' => 'General Settings',
            'descriptions' => 'Application general settings.', // (optional)
            'icon' => 'fa fa-cog', // (optional)

            'inputs' => [
                [
                    'name' => 'app_name', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'App Name', // label for input
                    // optional properties
                    'placeholder' => 'Application Name', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'rules' => 'required|min:2|max:20', // validation rules for this input
                    'value' => 'QCode', // any default value
                    'hint' => 'You can set the app name here' // help block text for input
                ],
                [
                    'name' => 'logo',
                    'type' => 'image',
                    'label' => 'Upload logo',
                    'class' => 'form-control',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    'disk' => 'public', // which disk you want to upload
                    'path' => 'app', // path on the disk,
                    'preview_class' => 'thumbnail',
                    'preview_style' => 'height:40px'
                ]
            ]
        ],
        'email' => [
            'title' => 'Email Settings',
            'descriptions' => 'How app email will be sent.',
            'icon' => 'fa fa-envelope',

            'inputs' => [
                [
                    'name' => 'from_email',
                    'type' => 'email',
                    'label' => 'From Email',
                    'placeholder' => 'Application from email',
                    'rules' => 'required|email',
                ],
                [
                    'name' => 'from_name',
                    'type' => 'text',
                    'label' => 'Email from Name',
                    'placeholder' => 'Email from Name',
                ]
            ]
        ],
      'sms' => [
        'title' => 'SMS Settings',
        'descriptions' => 'SMS sending API settings.', // (optional)
        'icon' => 'fa fa-sms', // (optional)
        'inputs' => [
          [
            'name' => 'sms_api_url', // unique key for setting
            'type' => 'url', // type of input can be text, number, textarea, select, boolean, checkbox etc.
            'label' => 'SMS API Url', // label for input
            // optional properties
            'placeholder' => 'http:// or https://', // placeholder for input
            'class' => 'form-control', // override global input_class
            'style' => '', // any inline styles
            'hint' => 'You can find url in SMS API provider control panel' // help block text for input
          ],
          [
            'name' => 'sms_api_key', // unique key for setting
            'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
            'label' => 'SMS API Key', // label for input
            // optional properties
            'placeholder' => 'C2001211642c3d57b2f236xxxxxxx', // placeholder for input
            'class' => 'form-control', // override global input_class
            'style' => '', // any inline styles
          ],[
            'name' => 'sms_sender_id', // unique key for setting
            'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
            'label' => 'SMS Sender ID', // label for input
            // optional properties
            'placeholder' => '8809612441566', // placeholder for input
            'class' => 'form-control', // override global input_class
            'style' => '', // any inline styles
            'hint' => 'You can find url in SMS API provider control panel' // help block text for input
          ],
        ]
      ],
      'new_dps_template'=> [
        'title' => 'Edit DPS SMS template',
        'descriptions' => 'Write SMS template which will be sent after opening new DPS A/C',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_dps_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no'
          ]
        ]
      ],
      'new_special_dps_template'=> [
        'title' => 'Edit Special DPS template',
        'descriptions' => 'Write SMS template which will be sent after opening new Special DPS A/C',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_special_dps_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no'
          ]
        ]
      ],
      'new_fdr_template'=> [
        'title' => 'Edit New FDR template',
        'descriptions' => 'Write SMS template which will be sent after opening new FDR A/C',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_fdr_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no <br> <b>[deposit]</b> - Deposited Amount'
          ]
        ]
      ],
      'new_daily_template'=> [
        'title' => 'Edit New Daily Savings template',
        'descriptions' => 'Write SMS template which will be sent after opening new Daily Savings A/C',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_daily_savings_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no'
          ]
        ]
      ],
      'new_daily_loan_template'=> [
        'title' => 'Edit New Daily Loan template',
        'descriptions' => 'Write SMS template which will be sent after new Daily Loan',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_daily_loan_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no <br> <b>[loan_amount]</b> - Loan Amount
<br> <b>[interest]</b> - Loan Interest <br> <b>[date]</b> - Loan Date <br> <b>[commencement]</b> - Loan Commencement'
          ]
        ]
      ],
      'new_dps_loan_template'=> [
        'title' => 'Edit New DPS Loan template',
        'descriptions' => 'Write SMS template which will be sent after new DPS',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_dps_loan_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no <br> <b>[loan_amount]</b> - Loan Amount
<br> <b>[interest_rate]</b> - Interest Rate<br> <b>[date]</b> - Loan Date <br> <b>[commencement]</b> - Loan Commencement <br> <b>[loan_balance]</b> - Loan Balance'
          ]
        ]
      ],
      'new_special_loan_template'=> [
        'title' => 'Edit New Special Loan template',
        'descriptions' => 'Write SMS template which will be sent after new Special Loan',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_special_loan_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no <br> <b>[loan_amount]</b> - Loan Amount
<br> <b>[interest_rate]</b> - Interest Rate<br> <b>[date]</b> - Loan Date <br> <b>[commencement]</b> - Loan Commencement <br> <b>[loan_balance]</b> - Loan Balance'
          ]
        ]
      ],
      'new_fdr_deposit_template'=> [
        'title' => 'Edit New FDR Deposit template',
        'descriptions' => 'Write SMS template which will be sent after new FDR deposit',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_fdr_deposit_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no <br> <b>[deposit]</b> - Deposited Amount
<br> <b>[date]</b> - Deposited Date <br> <b>[fdr_balance]</b> - FDR Balance'
          ]
        ]
      ],
      'new_fdr_withdraw_template'=> [
        'title' => 'Edit New FDR Withdraw template',
        'descriptions' => 'Write SMS template which will be sent after new FDR withdraw',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'new_fdr_withdraw_sms_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br> <b>[account_no]</b> - Customer A/C no <br> <b>[withdraw]</b> - Withdraw Amount
<br> <b>[date]</b> - Withdraw Date <br> <b>[fdr_balance]</b> - FDR Balance'
          ]
        ]
      ],
      'dps_installment_template'=> [
        'title' => 'Edit DPS Installment template',
        'descriptions' => 'Write SMS template which will be sent after DPS Installment',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'dps_installment_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total Payment<br>
                       <b>[dps_balance]</b> - DPS Balance<br>
                       <b>[loan_balance]</b> - Loan Balance<br>
                       <b>[transaction_id]</b> - Transaction ID'
          ]
        ]
      ],
      'special_installment_template'=> [
        'title' => 'Edit Special Installment template',
        'descriptions' => 'Write SMS template which will be sent after Special Installment',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'dps_installment_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total Payment<br>
                       <b>[dps_balance]</b> - DPS Balance<br>
                       <b>[loan_balance]</b> - Loan Balance<br>
                       <b>[transaction_id]</b> - Transaction ID'
          ]
        ]
      ],
      'fdr_profit_template'=> [
        'title' => 'Edit FDR Profit template',
        'descriptions' => 'Write SMS template which will be sent after FDR Profit Withdraw',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'fdr_profit_withdraw_template',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total Profit<br>
                       <b>[fdr_balance]</b> - FDR Balance<br>
                       <b>[transaction_id]</b> - Transaction ID'
          ]
        ]
      ],
      'daily_savings_complete'=> [
        'title' => 'Edit Daily Savings Complete template',
        'descriptions' => 'Write SMS template which will be sent after closing Daily Savings',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'daily_savings_complete',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total<br>
                       <b>[deposit]</b> - Principal Amount <br>
                       <b>[profit]</b> - Profit Amount'
          ]
        ]
      ],
      'dps_complete'=> [
        'title' => 'Edit DPS Complete template',
        'descriptions' => 'Write SMS template which will be sent after closing DPS',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'dps_complete',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total<br>
                       <b>[deposit]</b> - Principal Amount <br>
                       <b>[profit]</b> - Profit Amount'
          ]
        ]
      ],
      'special_dps_complete'=> [
        'title' => 'Edit Special DPS Complete template',
        'descriptions' => 'Write SMS template which will be sent after closing Special DPS',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'special_dps_complete',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total<br>
                       <b>[deposit]</b> - Principal Amount <br>
                       <b>[profit]</b> - Profit Amount'
          ]
        ]
      ],
      'fdr_complete'=> [
        'title' => 'Edit FDR Complete template',
        'descriptions' => 'Write SMS template which will be sent after closing FDR',
        'icon' => 'fa fa-edit',
        'inputs' => [
          [
            'name' => 'special_dps_complete',
            'type' => 'textarea',
            'label' => 'Template Content',
            'class' => 'form-control',
            'hint' => '<b>[name] </b> - Customer Name <br>
                       <b>[account_no]</b> - Customer A/C no  <br>
                       <b>[total]</b> - Total<br>
                       <b>[deposit]</b> - Principal Amount <br>
                       <b>[profit]</b> - Profit Amount'
          ]
        ]
      ]
    ],

    // Setting page url, will be used for get and post request
    'url' => 'settings',

    // Any middleware you want to run on above route
    'middleware' => [],

    // Route Names
    'route_names' => [
        'index' => 'settings.index',
        'store' => 'settings.store',
    ],

    // View settings
    'setting_page_view' => 'app_settings::settings_page',
    'flash_partial' => 'app_settings::_flash',

    // Setting section class setting
    'section_class' => 'card mb-3',
    'section_heading_class' => 'card-header border-bottom mb-4 py-3',
    'section_body_class' => 'card-body',

    // Input wrapper and group class setting
    'input_wrapper_class' => 'form-group mb-3',
    'input_class' => 'form-control',
    'input_error_class' => 'has-error',
    'input_invalid_class' => 'is-invalid',
    'input_hint_class' => 'form-text text-dark',
    'input_error_feedback_class' => 'text-danger',

    // Submit button
    'submit_btn_text' => 'Save Settings',
    'submit_success_message' => 'Settings has been saved.',

    // Remove any setting which declaration removed later from sections
    'remove_abandoned_settings' => false,

    // Controller to show and handle save setting
    'controller' => '\QCod\AppSettings\Controllers\AppSettingController',

    // settings group
    'setting_group' => function() {
        // return 'user_'.auth()->id();
        return 'default';
    }
];
