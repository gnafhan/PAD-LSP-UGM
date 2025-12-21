<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\IA02Template;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: IA02 Template Round Trip
 * 
 * Property 6: For any IA02 template content saved, retrieving the template
 * SHALL return content equivalent to what was saved (HTML preserved).
 * 
 * Validates: Requirements 2.2, 2.4
 */
class IA02TemplateRoundTripPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: Plain text content is preserved through save and retrieve.
     */
    public function test_plain_text_content_is_preserved(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();
            $content = fake()->paragraphs(fake()->numberBetween(1, 5), true);

            // Save template
            $this->service->saveIA02Template($scheme->id_skema, $content);

            // Retrieve template
            $retrieved = $this->service->getIA02Template($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($content, $retrieved->instruksi_kerja,
                "Plain text content should be preserved exactly");
        }
    }

    /**
     * Property: HTML content is preserved through save and retrieve.
     */
    public function test_html_content_is_preserved(): void
    {
        $htmlContents = [
            '<p>Simple paragraph</p>',
            '<h1>Heading</h1><p>Paragraph with <strong>bold</strong> and <em>italic</em></p>',
            '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>',
            '<ol><li>First</li><li>Second</li><li>Third</li></ol>',
            '<table><tr><th>Header</th></tr><tr><td>Cell</td></tr></table>',
            '<p>Text with <a href="https://example.com">link</a></p>',
            '<div class="custom"><p>Nested content</p></div>',
            '<p style="color: red;">Styled text</p>',
            '<blockquote>Quoted text</blockquote>',
            '<pre><code>Code block</code></pre>',
        ];

        foreach ($htmlContents as $html) {
            $scheme = Skema::factory()->create();

            // Save template
            $this->service->saveIA02Template($scheme->id_skema, $html);

            // Retrieve template
            $retrieved = $this->service->getIA02Template($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($html, $retrieved->instruksi_kerja,
                "HTML content should be preserved exactly: $html");
        }
    }

    /**
     * Property: Complex HTML with special characters is preserved.
     */
    public function test_complex_html_with_special_characters_is_preserved(): void
    {
        $complexContents = [
            '<p>Text with &amp; ampersand</p>',
            '<p>Text with &lt;angle brackets&gt;</p>',
            '<p>Text with "quotes" and \'apostrophes\'</p>',
            '<p>Unicode: café, naïve, 日本語</p>',
            '<p>Emoji: 🎉 🚀 ✅</p>',
            "<p>Newlines:\nLine 1\nLine 2</p>",
            "<p>Tabs:\tTabbed\tContent</p>",
        ];

        foreach ($complexContents as $content) {
            $scheme = Skema::factory()->create();

            // Save template
            $this->service->saveIA02Template($scheme->id_skema, $content);

            // Retrieve template
            $retrieved = $this->service->getIA02Template($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($content, $retrieved->instruksi_kerja,
                "Complex content should be preserved: $content");
        }
    }

    /**
     * Property: Empty content is handled correctly.
     */
    public function test_empty_content_is_handled(): void
    {
        $scheme = Skema::factory()->create();

        // Save empty template
        $this->service->saveIA02Template($scheme->id_skema, '');

        // Retrieve template
        $retrieved = $this->service->getIA02Template($scheme->id_skema);

        $this->assertNotNull($retrieved);
        $this->assertEquals('', $retrieved->instruksi_kerja);
    }

    /**
     * Property: Updating template preserves new content.
     */
    public function test_updating_template_preserves_new_content(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();
            
            // Save initial content
            $initialContent = fake()->paragraph();
            $this->service->saveIA02Template($scheme->id_skema, $initialContent);

            // Update with new content
            $newContent = fake()->paragraphs(3, true);
            $this->service->saveIA02Template($scheme->id_skema, $newContent);

            // Retrieve template
            $retrieved = $this->service->getIA02Template($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($newContent, $retrieved->instruksi_kerja,
                "Updated content should replace initial content");
            $this->assertNotEquals($initialContent, $retrieved->instruksi_kerja,
                "Initial content should be replaced");
        }
    }

    /**
     * Property: Multiple updates preserve the latest content.
     */
    public function test_multiple_updates_preserve_latest_content(): void
    {
        $scheme = Skema::factory()->create();
        $contents = [];

        // Perform multiple updates
        for ($i = 0; $i < 5; $i++) {
            $content = "Update $i: " . fake()->paragraph();
            $contents[] = $content;
            $this->service->saveIA02Template($scheme->id_skema, $content);
        }

        // Retrieve template
        $retrieved = $this->service->getIA02Template($scheme->id_skema);

        $this->assertNotNull($retrieved);
        $this->assertEquals(end($contents), $retrieved->instruksi_kerja,
            "Latest content should be preserved");
    }

    /**
     * Property: Only one template exists per scheme after multiple saves.
     */
    public function test_only_one_template_per_scheme(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();

            // Save multiple times
            $updateCount = fake()->numberBetween(2, 5);
            for ($j = 0; $j < $updateCount; $j++) {
                $this->service->saveIA02Template($scheme->id_skema, fake()->paragraph());
            }

            // Count templates for this scheme
            $templateCount = IA02Template::forSkema($scheme->id_skema)->count();

            $this->assertEquals(1, $templateCount,
                "Only one template should exist per scheme after $updateCount saves");
        }
    }

    /**
     * Property: Large content is preserved.
     */
    public function test_large_content_is_preserved(): void
    {
        $scheme = Skema::factory()->create();
        
        // Generate large content (approximately 100KB)
        $largeContent = str_repeat(fake()->paragraph() . "\n", 500);

        // Save template
        $this->service->saveIA02Template($scheme->id_skema, $largeContent);

        // Retrieve template
        $retrieved = $this->service->getIA02Template($scheme->id_skema);

        $this->assertNotNull($retrieved);
        $this->assertEquals($largeContent, $retrieved->instruksi_kerja,
            "Large content should be preserved");
    }
}
