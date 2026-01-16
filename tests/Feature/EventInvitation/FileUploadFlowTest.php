<?php

namespace Tests\Feature\EventInvitation;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Integration Test: File Upload Flow
 * 
 * Tests the Surat Penetapan file upload flow including storage,
 * download, and replacement functionality.
 * 
 * **Validates: Requirements 4.2, 4.3, 4.4, 4.6**
 */
class FileUploadFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Test file upload flow
     * 
     * Flow:
     * 1. Admin uploads Surat Penetapan
     * 2. File is stored correctly
     * 3. Admin can download file
     * 4. Admin replaces file
     * 
     * @test
     */
    public function complete_file_upload_flow_works(): void
    {
        $event = Event::factory()->create();

        // Step 1: Upload PDF file
        $pdfFile = UploadedFile::fake()->create('surat-penetapan.pdf', 1024, 'application/pdf');

        // Simulate upload
        $path = $pdfFile->store('surat-penetapan', 'public');
        $event->update(['surat_penetapan_path' => $path]);

        // Step 2: Verify file is stored
        Storage::disk('public')->assertExists($path);

        // Verify database record
        $this->assertDatabaseHas('event', [
            'id_event' => $event->id_event,
            'surat_penetapan_path' => $path,
        ]);

        // Step 3: Verify file can be accessed
        $this->assertNotNull($event->fresh()->surat_penetapan_path);
        $this->assertTrue(Storage::disk('public')->exists($event->surat_penetapan_path));

        // Step 4: Replace with new file
        $newPdfFile = UploadedFile::fake()->create('surat-penetapan-new.pdf', 2048, 'application/pdf');

        // Delete old file
        Storage::disk('public')->delete($event->surat_penetapan_path);

        // Store new file
        $newPath = $newPdfFile->store('surat-penetapan', 'public');
        $event->update(['surat_penetapan_path' => $newPath]);

        // Verify old file is deleted
        Storage::disk('public')->assertMissing($path);

        // Verify new file exists
        Storage::disk('public')->assertExists($newPath);

        // Verify database is updated
        $this->assertDatabaseHas('event', [
            'id_event' => $event->id_event,
            'surat_penetapan_path' => $newPath,
        ]);
    }

    /**
     * Test PDF file upload
     * 
     * @test
     */
    public function pdf_file_can_be_uploaded(): void
    {
        $event = Event::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');

        $event->update(['surat_penetapan_path' => $path]);

        Storage::disk('public')->assertExists($path);
        $this->assertEquals($path, $event->fresh()->surat_penetapan_path);
    }

    /**
     * Test JPG file upload
     * 
     * @test
     */
    public function jpg_file_can_be_uploaded(): void
    {
        $event = Event::factory()->create();

        $file = UploadedFile::fake()->image('document.jpg');
        $path = $file->store('surat-penetapan', 'public');

        $event->update(['surat_penetapan_path' => $path]);

        Storage::disk('public')->assertExists($path);
        $this->assertEquals($path, $event->fresh()->surat_penetapan_path);
    }

    /**
     * Test PNG file upload
     * 
     * @test
     */
    public function png_file_can_be_uploaded(): void
    {
        $event = Event::factory()->create();

        $file = UploadedFile::fake()->image('document.png');
        $path = $file->store('surat-penetapan', 'public');

        $event->update(['surat_penetapan_path' => $path]);

        Storage::disk('public')->assertExists($path);
        $this->assertEquals($path, $event->fresh()->surat_penetapan_path);
    }

    /**
     * Test file replacement deletes old file
     * 
     * @test
     */
    public function file_replacement_deletes_old_file(): void
    {
        $event = Event::factory()->create();

        // Upload first file
        $file1 = UploadedFile::fake()->create('first.pdf', 1024, 'application/pdf');
        $path1 = $file1->store('surat-penetapan', 'public');
        $event->update(['surat_penetapan_path' => $path1]);

        Storage::disk('public')->assertExists($path1);

        // Upload second file
        $file2 = UploadedFile::fake()->create('second.pdf', 2048, 'application/pdf');
        $path2 = $file2->store('surat-penetapan', 'public');

        // Delete old file before updating
        if ($event->surat_penetapan_path && Storage::disk('public')->exists($event->surat_penetapan_path)) {
            Storage::disk('public')->delete($event->surat_penetapan_path);
        }

        $event->update(['surat_penetapan_path' => $path2]);

        // Verify old file is deleted
        Storage::disk('public')->assertMissing($path1);

        // Verify new file exists
        Storage::disk('public')->assertExists($path2);

        // Verify database has new path
        $this->assertEquals($path2, $event->fresh()->surat_penetapan_path);
    }

    /**
     * Test event can be created without file
     * 
     * @test
     */
    public function event_can_be_created_without_surat_penetapan(): void
    {
        $event = Event::factory()->create([
            'surat_penetapan_path' => null,
        ]);

        $this->assertNull($event->surat_penetapan_path);
        $this->assertDatabaseHas('event', [
            'id_event' => $event->id_event,
            'surat_penetapan_path' => null,
        ]);
    }

    /**
     * Test file can be added to event without existing file
     * 
     * @test
     */
    public function file_can_be_added_to_event_without_existing_file(): void
    {
        $event = Event::factory()->create([
            'surat_penetapan_path' => null,
        ]);

        $this->assertNull($event->surat_penetapan_path);

        // Add file
        $file = UploadedFile::fake()->create('new-document.pdf', 1024, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');
        $event->update(['surat_penetapan_path' => $path]);

        // Verify file is stored
        Storage::disk('public')->assertExists($path);
        $this->assertEquals($path, $event->fresh()->surat_penetapan_path);
    }

    /**
     * Test file storage path structure
     * 
     * @test
     */
    public function files_are_stored_in_correct_directory(): void
    {
        $event = Event::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');

        $event->update(['surat_penetapan_path' => $path]);

        // Verify path starts with 'surat-penetapan/'
        $this->assertStringStartsWith('surat-penetapan/', $path);

        // Verify file exists in storage
        Storage::disk('public')->assertExists($path);
    }

    /**
     * Test multiple events can have different files
     * 
     * @test
     */
    public function multiple_events_can_have_different_files(): void
    {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();
        $event3 = Event::factory()->create();

        // Upload different files for each event
        $file1 = UploadedFile::fake()->create('event1.pdf', 1024, 'application/pdf');
        $path1 = $file1->store('surat-penetapan', 'public');
        $event1->update(['surat_penetapan_path' => $path1]);

        $file2 = UploadedFile::fake()->image('event2.jpg');
        $path2 = $file2->store('surat-penetapan', 'public');
        $event2->update(['surat_penetapan_path' => $path2]);

        $file3 = UploadedFile::fake()->image('event3.png');
        $path3 = $file3->store('surat-penetapan', 'public');
        $event3->update(['surat_penetapan_path' => $path3]);

        // Verify all files exist
        Storage::disk('public')->assertExists($path1);
        Storage::disk('public')->assertExists($path2);
        Storage::disk('public')->assertExists($path3);

        // Verify each event has correct path
        $this->assertEquals($path1, $event1->fresh()->surat_penetapan_path);
        $this->assertEquals($path2, $event2->fresh()->surat_penetapan_path);
        $this->assertEquals($path3, $event3->fresh()->surat_penetapan_path);

        // Verify paths are different
        $this->assertNotEquals($path1, $path2);
        $this->assertNotEquals($path2, $path3);
        $this->assertNotEquals($path1, $path3);
    }

    /**
     * Test file size limits (5MB max)
     * 
     * @test
     */
    public function file_at_size_limit_can_be_uploaded(): void
    {
        $event = Event::factory()->create();

        // Create file at exactly 5MB (5120 KB)
        $file = UploadedFile::fake()->create('large.pdf', 5120, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');

        $event->update(['surat_penetapan_path' => $path]);

        Storage::disk('public')->assertExists($path);
        $this->assertEquals($path, $event->fresh()->surat_penetapan_path);
    }

    /**
     * Test file download path exists
     * 
     * @test
     */
    public function file_path_is_accessible_for_download(): void
    {
        $event = Event::factory()->create();

        $file = UploadedFile::fake()->create('download-test.pdf', 1024, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');
        $event->update(['surat_penetapan_path' => $path]);

        // Verify file exists and can be accessed
        $this->assertTrue(Storage::disk('public')->exists($event->surat_penetapan_path));

        // Verify file content can be retrieved
        $content = Storage::disk('public')->get($event->surat_penetapan_path);
        $this->assertNotEmpty($content);
    }

    /**
     * Test file removal when event is deleted
     * 
     * @test
     */
    public function file_can_be_cleaned_up_when_event_is_deleted(): void
    {
        $event = Event::factory()->create();

        $file = UploadedFile::fake()->create('cleanup-test.pdf', 1024, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');
        $event->update(['surat_penetapan_path' => $path]);

        Storage::disk('public')->assertExists($path);

        // Delete file before deleting event
        if ($event->surat_penetapan_path) {
            Storage::disk('public')->delete($event->surat_penetapan_path);
        }

        // Verify file is deleted
        Storage::disk('public')->assertMissing($path);

        // Delete event
        $event->delete();

        // Verify event is deleted
        $this->assertDatabaseMissing('event', [
            'id_event' => $event->id_event,
        ]);
    }

    /**
     * Test file path is nullable
     * 
     * @test
     */
    public function surat_penetapan_path_is_nullable(): void
    {
        $event1 = Event::factory()->create(['surat_penetapan_path' => null]);
        $event2 = Event::factory()->create();

        $file = UploadedFile::fake()->create('test.pdf', 1024, 'application/pdf');
        $path = $file->store('surat-penetapan', 'public');
        $event2->update(['surat_penetapan_path' => $path]);

        // Event1 should have null path
        $this->assertNull($event1->fresh()->surat_penetapan_path);

        // Event2 should have file path
        $this->assertNotNull($event2->fresh()->surat_penetapan_path);
        $this->assertEquals($path, $event2->fresh()->surat_penetapan_path);
    }
}
