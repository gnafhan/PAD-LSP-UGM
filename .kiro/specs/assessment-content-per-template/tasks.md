# Implementation Plan

## Phase 1: Database & Core Models

- [x] 1. Create database migrations for new tables
  - [x] 1.1 Create migration to add display_order to soal table
    - Add display_order column with default 0
    - _Requirements: 1.5_
  - [x] 1.2 Create migration for ia02_templates table
    - Define columns: id, id_skema, instruksi_kerja (longtext), is_default
    - Add foreign key constraint to skema table
    - Add unique constraint on id_skema
    - _Requirements: 2.1, 2.2_
  - [x] 1.3 Create migration for ia07_questions table
    - Define columns: id, id_skema, id_uk, id_elemen_uk, pertanyaan, display_order, is_active
    - Add foreign key constraints
    - _Requirements: 3.1, 3.2_
  - [x] 1.4 Create migration for mapa01_configs table
    - Define columns: id, id_skema, config_data (JSON)
    - Add foreign key constraint and unique constraint on id_skema
    - _Requirements: 4.1, 4.2_
  - [x] 1.5 Create migration for mapa02_configs table
    - Define columns: id, id_skema, muk_items (JSON), default_potensi (JSON)
    - Add foreign key constraint and unique constraint on id_skema
    - _Requirements: 5.1, 5.2_
  - [x] 1.6 Create migration for ia11_checklists table
    - Define columns: id, id_skema, item_name, description, verification_criteria, display_order, is_required
    - Add foreign key constraint
    - _Requirements: 6.1, 6.2_

- [x] 2. Create new Eloquent models
  - [x] 2.1 Create IA02Template model
    - Define fillable, casts, and relationships
    - Add scope for default template
    - _Requirements: 2.1_
  - [x] 2.2 Create IA07Question model
    - Define fillable and relationships to Skema, UK, ElemenUK
    - Add scopes for active questions and ordering
    - _Requirements: 3.1, 3.2_
  - [x] 2.3 Create MAPA01Config model
    - Define fillable, casts (config_data as array), and relationships
    - _Requirements: 4.1_
  - [x] 2.4 Create MAPA02Config model
    - Define fillable, casts (muk_items, default_potensi as array), and relationships
    - _Requirements: 5.1_
  - [x] 2.5 Create IA11Checklist model
    - Define fillable and relationships
    - Add scopes for required items and ordering
    - _Requirements: 6.1_

- [x] 3. Update existing Soal model
  - [x] 3.1 Add display_order to fillable array
    - _Requirements: 1.5_
  - [x] 3.2 Add scopeOrdered for ordering by display_order
    - _Requirements: 1.1_

- [x] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 2: Core Services

- [x] 5. Create SchemeContentService
  - [x] 5.1 Implement IA05 question methods
    - getIA05Questions(), createIA05Question(), updateIA05Question(), deleteIA05Question(), reorderIA05Questions()
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_
  - [x] 5.2 Write property test for scheme content isolation
    - **Property 1: Scheme Content Isolation**
    - **Validates: Requirements 1.1, 2.1, 3.1, 6.1**
  - [x] 5.3 Write property test for IA05 question validation
    - **Property 2: IA05 Question Validation**
    - **Validates: Requirements 1.2**
  - [x] 5.4 Implement IA02 template methods
    - getIA02Template(), saveIA02Template()
    - _Requirements: 2.1, 2.2, 2.4_
  - [x] 5.5 Write property test for IA02 template round trip
    - **Property 6: IA02 Template Round Trip**
    - **Validates: Requirements 2.2, 2.4**
  - [x] 5.6 Implement IA07 question methods
    - getIA07Questions(), createIA07Question(), updateIA07Question(), deleteIA07Question()
    - _Requirements: 3.1, 3.2, 3.3, 3.4_
  - [x] 5.7 Write property test for IA07 question UK association
    - **Property 7: IA07 Question UK Association**
    - **Validates: Requirements 3.2**
  - [x] 5.8 Implement MAPA config methods
    - getMAPA01Config(), saveMAPA01Config(), getMAPA02Config(), saveMAPA02Config()
    - _Requirements: 4.1, 4.2, 5.1, 5.2, 5.3_
  - [x] 5.9 Write property test for MAPA config persistence
    - **Property 8: MAPA Config Persistence**
    - **Validates: Requirements 4.2, 5.2, 5.3**
  - [x] 5.10 Implement IA11 checklist methods
    - getIA11Checklist(), createIA11Item(), updateIA11Item(), deleteIA11Item()
    - _Requirements: 6.1, 6.2, 6.3, 6.4_
  - [x] 5.11 Implement dashboard methods
    - getContentSummary(), hasContent()
    - _Requirements: 7.1_

- [x] 6. Create ContentCopyService
  - [x] 6.1 Implement getSchemesWithContent() method
    - Return schemes that have at least one type of content
    - _Requirements: 9.1_
  - [x] 6.2 Implement copyAllContent() method
    - Copy all content types from source to target scheme
    - _Requirements: 9.2_
  - [x] 6.3 Write property test for content copy
    - **Property 10: Content Copy Duplicates All Items**
    - **Validates: Requirements 9.2**
  - [x] 6.4 Implement individual copy methods
    - copyIA05Content(), copyIA02Content(), copyIA07Content(), copyMAPAConfig(), copyIA11Content()
    - _Requirements: 9.2_

- [x] 7. Write property test for content edit preserves association
  - **Property 3: Content Edit Preserves Association**
  - **Validates: Requirements 1.3, 3.3, 6.3**

- [x] 8. Write property test for content deletion
  - **Property 4: Content Deletion Removes Item**
  - **Validates: Requirements 1.4, 3.4, 6.4**

- [x] 9. Write property test for question reorder
  - **Property 5: Question Reorder Persistence**
  - **Validates: Requirements 1.5**

- [x] 10. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 3: Controllers & API

- [x] 11. Create SchemeContentController
  - [x] 11.1 Implement index() method - GET /admin/skema/{id}/content
    - Return dashboard view with tabs for each content type
    - _Requirements: 7.1_
  - [x] 11.2 Implement summary() method - GET /admin/skema/{id}/content/summary
    - Return JSON summary of content counts
    - _Requirements: 7.1_

- [-] 12. Create IA05ContentController
  - [x] 12.1 Implement index() method - GET /admin/skema/{id}/content/ia05
    - Return list of questions for scheme
    - _Requirements: 1.1_
  - [x] 12.2 Implement store() method - POST /admin/skema/{id}/content/ia05
    - Create new question with validation
    - _Requirements: 1.2_
  - [x] 12.3 Implement update() method - PUT /admin/skema/{id}/content/ia05/{kode}
    - Update question
    - _Requirements: 1.3_
  - [x] 12.4 Implement destroy() method - DELETE /admin/skema/{id}/content/ia05/{kode}
    - Delete question
    - _Requirements: 1.4_
  - [x] 12.5 Implement reorder() method - POST /admin/skema/{id}/content/ia05/reorder
    - Reorder questions
    - _Requirements: 1.5_

- [x] 13. Create IA02ContentController
  - [x] 13.1 Implement show() method - GET /admin/skema/{id}/content/ia02
    - Return template content
    - _Requirements: 2.1_
  - [x] 13.2 Implement store() method - POST /admin/skema/{id}/content/ia02
    - Save template content
    - _Requirements: 2.2, 2.4_

- [x] 14. Create IA07ContentController
  - [x] 14.1 Implement index() method - GET /admin/skema/{id}/content/ia07
    - Return questions grouped by UK and elemen
    - _Requirements: 3.1_
  - [x] 14.2 Implement store() method - POST /admin/skema/{id}/content/ia07
    - Create new oral question
    - _Requirements: 3.2_
  - [x] 14.3 Implement update() method - PUT /admin/skema/{id}/content/ia07/{id}
    - Update oral question
    - _Requirements: 3.3_
  - [x] 14.4 Implement destroy() method - DELETE /admin/skema/{id}/content/ia07/{id}
    - Delete oral question
    - _Requirements: 3.4_

- [x] 15. Create MAPAConfigController
  - [x] 15.1 Implement showMAPA01() method - GET /admin/skema/{id}/content/mapa01
    - Return MAPA01 configuration
    - _Requirements: 4.1_
  - [x] 15.2 Implement storeMAPA01() method - POST /admin/skema/{id}/content/mapa01
    - Save MAPA01 configuration
    - _Requirements: 4.2_
  - [x] 15.3 Implement showMAPA02() method - GET /admin/skema/{id}/content/mapa02
    - Return MAPA02 configuration
    - _Requirements: 5.1_
  - [x] 15.4 Implement storeMAPA02() method - POST /admin/skema/{id}/content/mapa02
    - Save MAPA02 configuration
    - _Requirements: 5.2, 5.3_

- [-] 16. Create IA11ContentController
  - [x] 16.1 Implement index() method - GET /admin/skema/{id}/content/ia11
    - Return checklist items
    - _Requirements: 6.1_
  - [x] 16.2 Implement store() method - POST /admin/skema/{id}/content/ia11
    - Create checklist item
    - _Requirements: 6.2_
  - [x] 16.3 Implement update() method - PUT /admin/skema/{id}/content/ia11/{id}
    - Update checklist item
    - _Requirements: 6.3_
  - [x] 16.4 Implement destroy() method - DELETE /admin/skema/{id}/content/ia11/{id}
    - Delete checklist item
    - _Requirements: 6.4_

- [x] 17. Create ContentCopyController
  - [x] 17.1 Implement sources() method - GET /admin/content/copy/sources
    - Return schemes with content
    - _Requirements: 9.1_
  - [x] 17.2 Implement copy() method - POST /admin/content/copy
    - Copy content between schemes
    - _Requirements: 9.2, 9.3_

- [x] 18. Register routes
  - Add routes for all new controllers
  - Apply appropriate middleware (auth, admin)
  - _Requirements: All_

- [x] 19. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 4: Admin UI - Content Dashboard

- [x] 20. Create scheme content dashboard view
  - [x] 20.1 Create main dashboard layout with tabs
    - Tab for each content type: IA05, IA02, IA07, MAPA01, MAPA02, IA11
    - Created: resources/views/home/home-admin/scheme-content-dashboard.blade.php
    - _Requirements: 7.1, 7.2_
  - [x] 20.2 Create IA05 tab content
    - List questions with add/edit/delete/reorder functionality
    - Form for creating/editing questions
    - Created: resources/views/home/home-admin/partials/scheme-content/ia05-tab.blade.php
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_
  - [x] 20.3 Create IA02 tab content
    - Text editor for instruksi kerja with preview
    - Created: resources/views/home/home-admin/partials/scheme-content/ia02-tab.blade.php
    - _Requirements: 2.1, 2.2, 2.3_
  - [x] 20.4 Create IA07 tab content
    - Questions organized by UK and elemen
    - Add/edit/delete functionality
    - Created: resources/views/home/home-admin/partials/scheme-content/ia07-tab.blade.php
    - _Requirements: 3.1, 3.2, 3.3, 3.4_
  - [x] 20.5 Create MAPA01 tab content
    - Configuration form with checkboxes and radio buttons
    - Created: resources/views/home/home-admin/partials/scheme-content/mapa01-tab.blade.php
    - _Requirements: 4.1, 4.2_
  - [x] 20.6 Create MAPA02 tab content
    - MUK checklist configuration
    - Default potensi settings
    - Created: resources/views/home/home-admin/partials/scheme-content/mapa02-tab.blade.php
    - _Requirements: 5.1, 5.2, 5.3_
  - [x] 20.7 Create IA11 tab content
    - Checklist items management
    - Created: resources/views/home/home-admin/partials/scheme-content/ia11-tab.blade.php
    - _Requirements: 6.1, 6.2, 6.3, 6.4_

- [x] 21. Create content copy modal
  - [x] 21.1 Create modal for selecting source scheme
    - Created: resources/views/home/home-admin/partials/scheme-content/copy-modal.blade.php
    - _Requirements: 9.1_
  - [x] 21.2 Implement copy confirmation and progress
    - _Requirements: 9.2, 9.3, 9.4_

- [x] 22. Add navigation to content dashboard
  - [x] 22.1 Add link from skema management page
    - Link already exists in skema.blade.php pointing to admin.assessment-content.manage
    - Route admin.skema.content.index is registered
    - _Requirements: 7.1_

- [x] 23. Checkpoint - Ensure all tests pass
  - All 85 tests pass (4229 assertions)
  - All view files compile without errors

## Phase 5: Asesor Integration

- [-] 24. Modify asesor assessment views to use scheme-specific content
  - [x] 24.1 Modify fria05-asesor.blade.php
    - Load questions from Soal based on asesi's scheme
    - Show message if no questions configured
    - _Requirements: 8.1, 8.4_
  - [x] 24.2 Modify fria02-asesor.blade.php
    - Load template from IA02Template based on scheme
    - Fall back to default if no template
    - _Requirements: 8.2, 8.4_
  - [x] 24.3 Modify fria07-asesor.blade.php
    - Load questions from IA07Question based on scheme
    - Show message if no questions configured
    - _Requirements: 8.3, 8.4_
  - [x] 24.4 Modify frmapa01.blade.php
    - Pre-populate with scheme-specific defaults
    - _Requirements: 4.3_
  - [ ] 24.5 Modify frmapa02.blade.php
    - Use scheme-specific MUK configuration
    - _Requirements: 5.2_

- [x] 25. Write property test for asesor sees scheme-specific content
  - **Property 9: Asesor Sees Scheme-Specific Content**
  - **Validates: Requirements 8.1, 8.2, 8.3**

- [x] 26. Write property test for empty content fallback
  - **Property 11: Empty Content Fallback**
  - **Validates: Requirements 8.4**

- [x] 27. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 6: Data Migration & Cleanup

- [x] 28. Remove or deprecate generic assessment_content system
  - [x] 28.1 Update assessment-content-management.blade.php
    - Redirect to new scheme content dashboard or remove
    - _Requirements: 7.1_
  - [x] 28.2 Deprecate DynamicContentController
    - Add deprecation notice, redirect to new controllers
    - _Requirements: All_

- [x] 29. Create seeder for sample content
  - [x] 29.1 Create sample IA05 questions for existing schemes
    - _Requirements: 1.1_
  - [x] 29.2 Create sample IA02 templates for existing schemes
    - _Requirements: 2.1_
  - [x] 29.3 Create sample IA07 questions for existing schemes
    - _Requirements: 3.1_

- [x] 30. Final Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.
