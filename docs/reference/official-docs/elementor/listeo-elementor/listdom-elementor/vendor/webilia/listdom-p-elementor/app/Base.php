<?php
namespace LSDPACELM;

class Base
{
    const PTYPE_DETAILS = 'listdom-elm-details';

    public function include_html_file($file = '', $args = [])
    {
        // File is empty
        if (!trim($file)) return esc_html__('HTML file path is empty.', 'listdom-elementor');

        // Core File
        $path = dirname(__FILE__) . '/../html/' . ltrim($file, '/');

        // Apply Filter
        $path = apply_filters('lsdaddelm_include_html_file', $path, $file, $args);

        // File does not exist
        if (!file_exists($path)) return esc_html__('HTML file does not exist! Check the file path.', 'listdom-elementor');

        // Return the File Path
        if (isset($args['return_path']) && $args['return_path']) return $path;

        // Parameters passed
        if (isset($args['parameters']) && is_array($args['parameters']) && count($args['parameters'])) extract($args['parameters']);

        // Start buffering
        ob_start();

        // Include Once
        if (isset($args['include_once']) && $args['include_once']) include_once $path;
        else include $path;

        // Get Buffer
        $output = ob_get_clean();

        // Return the file output
        if (isset($args['return_output']) && $args['return_output']) return $output;

        // Print the output
        echo $output;
        return '';
    }

    public static function get_layout_type($post_id): string
    {
        $type = get_post_meta($post_id, 'lsd_type', true);
        if (!$type) $type = 'details';

        return $type;
    }

    public function get_layout_types(): array
    {
        return apply_filters('lsdaddelm_layout_types', [
            'details' => esc_html__('Single Listing', 'listdom-elementor'),
            'card' => esc_html__('Listing Card', 'listdom-elementor'),
        ]);
    }

    public function response(array $response)
    {
        echo wp_json_encode($response, JSON_NUMERIC_CHECK);
        exit;
    }
}
