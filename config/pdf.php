<?php

return [
  'mode'                     => '',
  'format'                   => 'A4',
  'default_font_size'        => '14',
  'default_font'             => 'sans-serif',
  'margin_left'              => 0,
  'margin_right'             => 0,
  'margin_top'               => 0,
  'margin_bottom'            => 0,
  'margin_header'            => 0,
  'margin_footer'            => 0,
  'orientation'              => 'P',
  'title'                    => 'FreedomSSSL',
  'subject'                  => '',
  'author'                   => '',
  'watermark'                => '',
  'show_watermark'           => false,
  'show_watermark_image'     => true,
  'watermark_font'           => 'sans-serif',
  'display_mode'             => 'fullpage',
  'watermark_text_alpha'     => 0.1,
  'watermark_image_path'     => base_path('resources/watermark/freedom-logo.jpg'),
  'watermark_image_alpha'    => 0.1,
  'watermark_image_size'     => 'D',
  'watermark_image_position' => 'P',
  'custom_font_dir'  => base_path('resources/fonts/'), // don't forget the trailing slash!
  'custom_font_data' => [
    'solaimanlipi' => [ // must be lowercase and snake_case
      'R'  => 'SolaimanLipi.ttf',    // regular font
      'useOTL' => 0xFF,
    ]
  ],
  'auto_language_detection'  => false,
  'temp_dir'                 => storage_path('app'),
  'pdfa'                     => false,
  'pdfaauto'                 => false,
  'use_active_forms'         => false,
];
