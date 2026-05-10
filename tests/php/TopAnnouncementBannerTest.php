<?php

use PHPUnit\Framework\TestCase;

final class TopAnnouncementBannerTest extends TestCase
{
    private Top_Announcement_Banner $plugin;

    protected function setUp(): void
    {
        $reflection = new ReflectionClass(Top_Announcement_Banner::class);
        $this->plugin = $reflection->newInstanceWithoutConstructor();
    }

    public function test_sanitize_options_handles_partial_input_without_warnings(): void
    {
        $options = $this->plugin->sanitize_options(
            array(
                'enabled' => '1',
                'message' => '<strong>Sale</strong>',
            )
        );

        $this->assertSame(1, $options['enabled']);
        $this->assertSame('Sale', $options['message']);
        $this->assertSame('#d95459', $options['background_color']);
        $this->assertSame('#ffffff', $options['text_color']);
        $this->assertSame(0, $options['dismissible']);
    }

    public function test_sanitize_options_rejects_invalid_color_values(): void
    {
        $options = $this->plugin->sanitize_options(
            array(
                'background_color' => '#fff; color: red',
                'text_color' => 'expression(alert(1))',
            )
        );

        $this->assertSame('#d95459', $options['background_color']);
        $this->assertSame('#ffffff', $options['text_color']);
    }
}
