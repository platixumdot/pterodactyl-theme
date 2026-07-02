<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Pltx\Theme\Models\ThemeSetting;

final class ThemeEditorService
{
    /** Default design tokens */
    public static function defaults(): array
    {
        return [
            // Colors
            'color_primary'        => '#3b82f6',
            'color_primary_hover'  => '#2563eb',
            'color_secondary'      => '#8b5cf6',
            'color_accent'         => '#06b6d4',
            'color_success'        => '#22c55e',
            'color_warning'        => '#f59e0b',
            'color_danger'         => '#ef4444',
            'color_bg'             => '#0f0f0f',
            'color_surface'        => '#1a1a1a',
            'color_surface2'       => '#242424',
            'color_border'         => '#2e2e2e',
            'color_text'           => '#f1f5f9',
            'color_text_muted'     => '#94a3b8',
            'color_sidebar_bg'     => '#111111',
            'color_topbar_bg'      => '#161616',
            'color_card_bg'        => '#1e1e1e',
            // Typography
            'font_family'          => 'Inter, system-ui, sans-serif',
            'font_size_base'       => '14px',
            'font_size_sm'         => '12px',
            'font_size_lg'         => '16px',
            'font_weight_normal'   => '400',
            'font_weight_medium'   => '500',
            'font_weight_bold'     => '700',
            'line_height'          => '1.6',
            // Borders & Radius
            'border_radius_sm'     => '6px',
            'border_radius_md'     => '10px',
            'border_radius_lg'     => '16px',
            'border_radius_xl'     => '24px',
            'border_width'         => '1px',
            // Spacing
            'spacing_xs'           => '4px',
            'spacing_sm'           => '8px',
            'spacing_md'           => '16px',
            'spacing_lg'           => '24px',
            'spacing_xl'           => '32px',
            // Sidebar
            'sidebar_width'        => '240px',
            'sidebar_collapsed_width' => '64px',
            // Misc
            'topbar_height'        => '60px',
            'shadow_sm'            => '0 1px 3px rgba(0,0,0,0.4)',
            'shadow_md'            => '0 4px 12px rgba(0,0,0,0.5)',
            'shadow_lg'            => '0 8px 32px rgba(0,0,0,0.6)',
            'transition_speed'     => '0.2s',
            'brand_name'           => 'PLTX Theme',
            'custom_css'           => '',
        ];
    }

    public function load(): array
    {
        $stored   = ThemeSetting::allAsArray();
        $defaults = self::defaults();
        return array_merge($defaults, array_intersect_key($stored, $defaults));
    }

    public function save(array $values): void
    {
        $allowed = self::defaults();
        foreach ($values as $key => $value) {
            if (array_key_exists($key, $allowed)) {
                ThemeSetting::set($key, (string) $value);
            }
        }
    }

    public function reset(): void
    {
        foreach (self::defaults() as $key => $value) {
            ThemeSetting::set($key, (string) $value);
        }
    }

    public function exportJson(): string
    {
        return json_encode($this->load(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function importJson(string $json): bool
    {
        $data = json_decode($json, true);
        if (! is_array($data)) {
            return false;
        }
        $this->save($data);
        return true;
    }

    /** Render all settings as CSS custom properties */
    public function toCss(array $settings): string
    {
        $map = [
            'color_primary'           => '--pltx-primary',
            'color_primary_hover'     => '--pltx-primary-hover',
            'color_secondary'         => '--pltx-secondary',
            'color_accent'            => '--pltx-accent',
            'color_success'           => '--pltx-success',
            'color_warning'           => '--pltx-warning',
            'color_danger'            => '--pltx-danger',
            'color_bg'                => '--pltx-bg',
            'color_surface'           => '--pltx-surface',
            'color_surface2'          => '--pltx-surface2',
            'color_border'            => '--pltx-border',
            'color_text'              => '--pltx-text',
            'color_text_muted'        => '--pltx-text-muted',
            'color_sidebar_bg'        => '--pltx-sidebar-bg',
            'color_topbar_bg'         => '--pltx-topbar-bg',
            'color_card_bg'           => '--pltx-card-bg',
            'font_family'             => '--pltx-font-family',
            'font_size_base'          => '--pltx-font-size',
            'font_size_sm'            => '--pltx-font-size-sm',
            'font_size_lg'            => '--pltx-font-size-lg',
            'font_weight_normal'      => '--pltx-font-weight',
            'font_weight_medium'      => '--pltx-font-weight-medium',
            'font_weight_bold'        => '--pltx-font-weight-bold',
            'line_height'             => '--pltx-line-height',
            'border_radius_sm'        => '--pltx-radius-sm',
            'border_radius_md'        => '--pltx-radius',
            'border_radius_lg'        => '--pltx-radius-lg',
            'border_radius_xl'        => '--pltx-radius-xl',
            'border_width'            => '--pltx-border-width',
            'spacing_xs'              => '--pltx-spacing-xs',
            'spacing_sm'              => '--pltx-spacing-sm',
            'spacing_md'              => '--pltx-spacing-md',
            'spacing_lg'              => '--pltx-spacing-lg',
            'spacing_xl'              => '--pltx-spacing-xl',
            'sidebar_width'           => '--pltx-sidebar-width',
            'sidebar_collapsed_width' => '--pltx-sidebar-collapsed-width',
            'topbar_height'           => '--pltx-topbar-height',
            'shadow_sm'               => '--pltx-shadow-sm',
            'shadow_md'               => '--pltx-shadow',
            'shadow_lg'               => '--pltx-shadow-lg',
            'transition_speed'        => '--pltx-transition',
        ];

        $vars = [':root {'];
        foreach ($map as $key => $var) {
            $val = $settings[$key] ?? '';
            if ($val !== '') {
                $vars[] = "  {$var}: {$val};";
            }
        }
        $vars[] = '}';

        $customCss = $settings['custom_css'] ?? '';
        if ($customCss !== '') {
            $vars[] = '';
            $vars[] = '/* Custom CSS */';
            $vars[] = $customCss;
        }

        return implode("\n", $vars);
    }
}
