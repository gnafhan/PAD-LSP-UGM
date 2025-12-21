<?php

namespace Tests\Feature\DynamicAssessment;

use App\Models\AssessmentContent;
use App\Models\Skema;
use App\Models\User;
use App\Services\AssessmentContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for AssessmentContentService
 * 
 * **Feature: dynamic-assessment-flow, Property 6: Content Edit Preserves Association**
 * **Validates: Requirements 4.4**
 * 
 * Property: For any assessment content, editing the content SHALL not change its scheme association.
 */
class AssessmentContentServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    private AssessmentContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AssessmentContentService();
    }

    /**
     * Property 6: Content Edit Preserves Association
     * 
     * For any assessment content, editing the content SHALL not change its scheme association.
     * 
     * **Feature: dynamic-assessment-flow, Property 6: Content Edit Preserves Association**
     * **Validates: Requirements 4.4**
     * 
     * @test
     */
    public function editing_content_preserves_scheme_association(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create two different schemes
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();
            $user = User::factory()->create();

            // Create content for scheme1
            $originalAssessmentType = fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES);
            $originalContentType = fake()->randomElement(AssessmentContent::CONTENT_TYPES);
            $originalContentData = [
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'unique_id' => fake()->uuid(),
            ];

            $content = $this->service->createContent([
                'id_skema' => $scheme1->id_skema,
                'assessment_type' => $originalAssessmentType,
                'content_type' => $originalContentType,
                'content_data' => $originalContentData,
                'created_by' => $user->id_user,
            ]);

            $originalSkemaId = $content->id_skema;

            // Generate random update data - including an attempt to change id_skema
            $newAssessmentType = fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES);
            $newContentType = fake()->randomElement(AssessmentContent::CONTENT_TYPES);
            $newContentData = [
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'updated' => true,
            ];

            // Attempt to update with different scheme (should be ignored)
            $updateData = [
                'id_skema' => $scheme2->id_skema, // This should be ignored
                'assessment_type' => $newAssessmentType,
                'content_type' => $newContentType,
                'content_data' => $newContentData,
                'display_order' => fake()->numberBetween(0, 100),
            ];

            // Perform update
            $this->service->updateContent($content->id, $updateData);

            // Refresh content from database
            $content->refresh();

            // Assert: Scheme association is preserved (Property 6)
            $this->assertEquals(
                $originalSkemaId,
                $content->id_skema,
                "Scheme association should be preserved after edit (iteration {$i})"
            );

            // Assert: Content is still retrievable from original scheme
            $scheme1Content = AssessmentContent::forSkema($scheme1->id_skema)->get();
            $this->assertTrue(
                $scheme1Content->contains('id', $content->id),
                "Content should still be retrievable from original scheme after edit"
            );

            // Assert: Content is NOT retrievable from the scheme we tried to change to
            $scheme2Content = AssessmentContent::forSkema($scheme2->id_skema)->get();
            $this->assertFalse(
                $scheme2Content->contains('id', $content->id),
                "Content should NOT be retrievable from scheme2 after edit attempt"
            );

            // Assert: Other fields were updated correctly
            $this->assertEquals($newAssessmentType, $content->assessment_type);
            $this->assertEquals($newContentType, $content->content_type);
            $this->assertEquals($newContentData, $content->content_data);

            // Clean up
            $content->delete();
            $scheme1->delete();
            $scheme2->delete();
            $user->delete();
        }
    }


    /**
     * Property: Content created via service is associated with correct scheme
     * 
     * @test
     */
    public function content_created_via_service_is_associated_with_correct_scheme(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $scheme = Skema::factory()->create();
            $user = User::factory()->create();

            $assessmentType = fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES);
            $contentType = fake()->randomElement(AssessmentContent::CONTENT_TYPES);
            $contentData = [
                'title' => fake()->sentence(),
                'data' => fake()->paragraph(),
            ];

            $content = $this->service->createContent([
                'id_skema' => $scheme->id_skema,
                'assessment_type' => $assessmentType,
                'content_type' => $contentType,
                'content_data' => $contentData,
                'created_by' => $user->id_user,
            ]);

            // Assert content is associated with the scheme
            $this->assertEquals($scheme->id_skema, $content->id_skema);

            // Assert content is retrievable via service
            $retrievedContent = $this->service->getContentBySkema($scheme->id_skema);
            $this->assertTrue($retrievedContent->contains('id', $content->id));

            // Assert content is retrievable with assessment type filter
            $filteredContent = $this->service->getContentBySkema($scheme->id_skema, $assessmentType);
            $this->assertTrue($filteredContent->contains('id', $content->id));

            // Clean up
            $content->delete();
            $scheme->delete();
            $user->delete();
        }
    }

    /**
     * Property: Deleted content is no longer retrievable
     * 
     * @test
     */
    public function deleted_content_is_no_longer_retrievable(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $scheme = Skema::factory()->create();
            $user = User::factory()->create();

            $content = $this->service->createContent([
                'id_skema' => $scheme->id_skema,
                'assessment_type' => fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                'content_type' => fake()->randomElement(AssessmentContent::CONTENT_TYPES),
                'content_data' => ['test' => fake()->word()],
                'created_by' => $user->id_user,
            ]);

            $contentId = $content->id;

            // Delete the content
            $this->service->deleteContent($contentId);

            // Assert content is no longer retrievable
            $schemeContent = $this->service->getContentBySkema($scheme->id_skema);
            $this->assertFalse(
                $schemeContent->contains('id', $contentId),
                "Deleted content should not be retrievable"
            );

            // Assert content no longer exists in database
            $this->assertNull(AssessmentContent::find($contentId));

            // Clean up
            $scheme->delete();
            $user->delete();
        }
    }

    /**
     * Property: Multiple edits preserve scheme association
     * 
     * @test
     */
    public function multiple_edits_preserve_scheme_association(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();
            $user = User::factory()->create();

            $content = $this->service->createContent([
                'id_skema' => $scheme1->id_skema,
                'assessment_type' => fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                'content_type' => fake()->randomElement(AssessmentContent::CONTENT_TYPES),
                'content_data' => ['version' => 1],
                'created_by' => $user->id_user,
            ]);

            $originalSkemaId = $content->id_skema;

            // Perform multiple edits, each attempting to change scheme
            $numEdits = fake()->numberBetween(3, 7);
            for ($j = 0; $j < $numEdits; $j++) {
                $this->service->updateContent($content->id, [
                    'id_skema' => $scheme2->id_skema, // Should be ignored
                    'content_data' => ['version' => $j + 2, 'edit' => $j],
                ]);

                $content->refresh();

                // Assert scheme association is preserved after each edit
                $this->assertEquals(
                    $originalSkemaId,
                    $content->id_skema,
                    "Scheme association should be preserved after edit {$j}"
                );
            }

            // Final verification
            $this->assertEquals($originalSkemaId, $content->id_skema);
            $this->assertEquals(['version' => $numEdits + 1, 'edit' => $numEdits - 1], $content->content_data);

            // Clean up
            $content->delete();
            $scheme1->delete();
            $scheme2->delete();
            $user->delete();
        }
    }

    /**
     * Property: Service validates required fields on create
     * 
     * @test
     */
    public function service_validates_required_fields_on_create(): void
    {
        $scheme = Skema::factory()->create();
        $user = User::factory()->create();

        $requiredFields = ['id_skema', 'assessment_type', 'content_type', 'content_data', 'created_by'];

        foreach ($requiredFields as $missingField) {
            $data = [
                'id_skema' => $scheme->id_skema,
                'assessment_type' => 'IA02',
                'content_type' => 'essay',
                'content_data' => ['test' => 'data'],
                'created_by' => $user->id_user,
            ];

            unset($data[$missingField]);

            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage("Missing required field: {$missingField}");
            
            $this->service->createContent($data);
        }

        // Clean up
        $scheme->delete();
        $user->delete();
    }

    /**
     * Property: Service validates assessment type
     * 
     * @test
     */
    public function service_validates_assessment_type(): void
    {
        $scheme = Skema::factory()->create();
        $user = User::factory()->create();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid assessment type");

        $this->service->createContent([
            'id_skema' => $scheme->id_skema,
            'assessment_type' => 'INVALID_TYPE',
            'content_type' => 'essay',
            'content_data' => ['test' => 'data'],
            'created_by' => $user->id_user,
        ]);

        // Clean up
        $scheme->delete();
        $user->delete();
    }

    /**
     * Property: Service validates content type
     * 
     * @test
     */
    public function service_validates_content_type(): void
    {
        $scheme = Skema::factory()->create();
        $user = User::factory()->create();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid content type");

        $this->service->createContent([
            'id_skema' => $scheme->id_skema,
            'assessment_type' => 'IA02',
            'content_type' => 'INVALID_TYPE',
            'content_data' => ['test' => 'data'],
            'created_by' => $user->id_user,
        ]);

        // Clean up
        $scheme->delete();
        $user->delete();
    }
}
