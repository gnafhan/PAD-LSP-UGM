# Implementation Plan

## Phase 1: Database & Core Models

- [x] 1. Create database migrations for new tables
  - [x] 1.1 Create migration for `skema_assessment_config` table
    - Define columns: id, id_skema, assessment_type, is_enabled, display_order, config_data (JSON)
    - Add foreign key constraint to skema table
    - Add unique constraint on (id_skema, assessment_type)
    - _Requirements: 1.1, 1.2_
  - [x] 1.2 Create migration for `asesor_skema_assignment` table
    - Define columns: id, id_asesor, id_skema, assigned_by, assigned_at
    - Add foreign key constraints to asesor, skema, and users tables
    - Add unique constraint on (id_asesor, id_skema)
    - _Requirements: 3.1, 3.2_
  - [x] 1.3 Create migration for `assessment_content` table
    - Define columns: id, id_skema, assessment_type, content_type, content_data (JSON), created_by, display_order
    - Add foreign key constraints
    - _Requirements: 4.1, 4.2_

- [x] 2. Create new Eloquent models
  - [x] 2.1 Create SkemaAssessmentConfig model
    - Define fillable, casts, and relationships
    - Add scope for enabled assessments
    - Add validation for mandatory APL types
    - _Requirements: 1.2, 1.3_
  - [x] 2.2 Write property test for APL mandatory invariant
    - **Property 1: APL Tools Mandatory Invariant**
    - **Validates: Requirements 1.3, 2.4**
  - [x] 2.3 Create AsesorSkemaAssignment model
    - Define fillable and relationships
    - Add scope for asesor's assignments
    - _Requirements: 3.2, 3.3_
  - [x] 2.4 Create AssessmentContent model
    - Define fillable, casts, and relationships
    - Add scope for content by scheme and type
    - _Requirements: 4.1, 4.2_
  - [x] 2.5 Write property test for content-scheme association
    - **Property 5: Content-Scheme Association**
    - **Validates: Requirements 4.1, 4.2, 4.3**

- [x] 3. Create AssessmentType enum class
  - Define all assessment type constants
  - Implement getMandatoryTypes() method
  - Implement getConfigurableTypes() method
  - _Requirements: 1.3_

- [x] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 2: Core Services

- [x] 5. Create SkemaConfigService
  - [x] 5.1 Implement getEnabledAssessments() method
    - Query skema_assessment_config for enabled assessments
    - Always include mandatory APL types
    - _Requirements: 1.1, 5.1_
  - [x] 5.2 Implement updateAssessmentConfig() method
    - Validate APL types cannot be disabled
    - Update or create config records
    - _Requirements: 1.2, 1.3, 1.4_
  - [x] 5.3 Write property test for configuration persistence
    - **Property 2: Assessment Configuration Persistence**
    - **Validates: Requirements 1.2, 2.3**
  - [x] 5.4 Implement getDefaultConfig() method
    - Return default configuration with all assessments enabled
    - _Requirements: 7.1_
  - [x] 5.5 Implement isAssessmentEnabled() method
    - Check if specific assessment is enabled for scheme
    - _Requirements: 5.3_

- [x] 6. Create AccessControlService
  - [x] 6.1 Implement canManageSkema() method
    - Check if user is admin (full access) or asesor with assignment
    - _Requirements: 2.1, 2.2_
  - [x] 6.2 Write property test for asesor scheme access control
    - **Property 3: Asesor Scheme Access Control**
    - **Validates: Requirements 2.1, 2.2**
  - [x] 6.3 Implement getAssignedSkemas() method
    - Return collection of schemes assigned to asesor
    - _Requirements: 2.1_
  - [x] 6.4 Implement assignSkemaToAsesor() method
    - Create assignment record
    - _Requirements: 3.2_
  - [x] 6.5 Implement revokeSkemaFromAsesor() method
    - Delete assignment record
    - _Requirements: 3.3_
  - [x] 6.6 Write property test for assignment creates/revokes access
    - **Property 4: Assignment Creates Access**
    - **Validates: Requirements 3.2, 3.3**

- [x] 7. Create AssessmentContentService
  - [x] 7.1 Implement getContentBySkema() method
    - Query content filtered by scheme and assessment type
    - _Requirements: 4.3_
  - [x] 7.2 Implement createContent() method
    - Create content with scheme association
    - _Requirements: 4.1, 4.2_
  - [x] 7.3 Implement updateContent() method
    - Update content while preserving scheme association
    - _Requirements: 4.4_
  - [x] 7.4 Write property test for content edit preserves association
    - **Property 6: Content Edit Preserves Association**
    - **Validates: Requirements 4.4**
  - [x] 7.5 Implement deleteContent() method
    - Delete content from scheme
    - _Requirements: 4.5_

- [x] 8. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 3: Extend Existing Models & Services

- [x] 9. Extend Skema model
  - [x] 9.1 Add assessmentConfig() relationship
    - HasMany relationship to SkemaAssessmentConfig
    - _Requirements: 1.1_
  - [x] 9.2 Add asesorAssignments() relationship
    - HasMany relationship to AsesorSkemaAssignment
    - _Requirements: 3.1_
  - [x] 9.3 Add getEnabledAssessments() method
    - Return array of enabled assessment types for this scheme
    - _Requirements: 5.1_

- [x] 10. Extend Asesor model
  - [x] 10.1 Add skemaAssignments() relationship
    - HasMany relationship to AsesorSkemaAssignment
    - _Requirements: 3.1_
  - [x] 10.2 Add getAssignedSkemas() method
    - Return collection of assigned schemes
    - _Requirements: 2.1_
  - [x] 10.3 Add canAccessSkema() method
    - Check if asesor has access to specific scheme
    - _Requirements: 2.2_

- [x] 11. Extend ProgresAsesmen model
  - [x] 11.1 Add isAssessmentEnabledForScheme() method
    - Check if assessment step is enabled for asesi's scheme
    - Inject SkemaConfigService or use static method
    - _Requirements: 5.1, 5.3_
  - [x] 11.2 Add getEnabledAssessmentsProgress() method
    - Return progress only for enabled assessments
    - _Requirements: 5.1_
  - [x] 11.3 Modify calculateProgress() method
    - Calculate progress based on enabled assessments only
    - Maintain backward compatibility for schemes without config
    - _Requirements: 8.3_
  - [x] 11.4 Write property test for asesi sees only enabled assessments
    - **Property 7: Asesi Sees Only Enabled Assessments**
    - **Validates: Requirements 5.1, 5.3**

- [x] 12. Extend ProgressTrackingService
  - [x] 12.1 Inject SkemaConfigService dependency
    - Add constructor injection
    - _Requirements: 8.3_
  - [x] 12.2 Add getEnabledProgressData() method
    - Return progress data filtered by enabled assessments
    - _Requirements: 8.3_
  - [x] 12.3 Add calculateSchemeBasedProgress() method
    - Calculate progress percentage based on enabled assessments
    - _Requirements: 8.3_
  - [x] 12.4 Add isStepEnabledForAsesi() method
    - Check if step is enabled for asesi's scheme
    - _Requirements: 5.3_
  - [x] 12.5 Write property test for progress record creation and update
    - **Property 13: Progress Record Creation**
    - **Property 14: Progress Completion Update**
    - **Validates: Requirements 8.1, 8.2**

- [x] 13. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 4: Controllers & API

- [x] 14. Create SkemaAssessmentConfigController
  - [x] 14.1 Implement index() method - GET /admin/skema/{id}/assessment-config
    - Return current assessment configuration for scheme
    - _Requirements: 1.1_
  - [x] 14.2 Implement update() method - PUT /admin/skema/{id}/assessment-config
    - Update assessment configuration
    - Validate APL cannot be disabled
    - _Requirements: 1.2, 1.3, 1.4_
  - [x] 14.3 Add authorization middleware
    - Check admin or assigned asesor access
    - _Requirements: 2.1, 2.2_

- [x] 15. Create AsesorSkemaAssignmentController
  - [x] 15.1 Implement index() method - GET /admin/asesor/{id}/assignments
    - Return asesor's assigned schemes
    - _Requirements: 3.1_
  - [x] 15.2 Implement store() method - POST /admin/asesor/{id}/assign-skema
    - Assign scheme to asesor
    - _Requirements: 3.2_
  - [x] 15.3 Implement destroy() method - DELETE /admin/asesor/{id}/revoke-skema/{skemaId}
    - Revoke scheme from asesor
    - _Requirements: 3.3_
  - [x] 15.4 Add admin-only authorization
    - Only admin can manage assignments
    - _Requirements: 3.2, 3.3_

- [x] 16. Create DynamicContentController
  - [x] 16.1 Implement index() method - GET /assessment-content/{skemaId}/{type}
    - Return content for scheme and assessment type
    - _Requirements: 4.3_
  - [x] 16.2 Implement store() method - POST /assessment-content
    - Create new assessment content
    - _Requirements: 4.1, 4.2_
  - [x] 16.3 Implement update() method - PUT /assessment-content/{id}
    - Update existing content
    - _Requirements: 4.4_
  - [x] 16.4 Implement destroy() method - DELETE /assessment-content/{id}
    - Delete content
    - _Requirements: 4.5_

- [x] 17. Register routes
  - Add routes for all new controllers
  - Apply appropriate middleware (auth, admin)
  - _Requirements: 1.1, 3.1, 4.1_

- [x] 18. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 5: Frontend - Dynamic Sidebar

- [x] 19. Create SidebarService for dynamic menu generation
  - [x] 19.1 Implement getMenuItemsForScheme() method
    - Return menu items based on scheme's enabled assessments
    - Always include APL items
    - _Requirements: 6.1, 6.2, 6.3_
  - [x] 19.2 Write property test for sidebar reflects enabled tools
    - **Property 9: Sidebar Reflects Enabled Tools**
    - **Validates: Requirements 6.1, 6.2, 6.3, 6.4**

- [x] 20. Modify sidebar.blade.php for Asesor
  - [x] 20.1 Add scheme context selector component
    - Dropdown to select active scheme
    - Store selected scheme in session
    - _Requirements: 6.1, 6.4_
  - [x] 20.2 Make Pelaksanaan Asesmen section dynamic
    - Show only enabled assessment tools
    - APL items always visible
    - _Requirements: 6.1, 6.2, 6.3_
  - [x] 20.3 Make Perangkat Asesmen section dynamic
    - Show only enabled assessment tools
    - _Requirements: 6.1, 6.2_
  - [x] 20.4 Make Keputusan Asesmen section dynamic
    - Show only enabled assessment tools
    - _Requirements: 6.1, 6.2_

- [x] 21. Create Asesi dashboard modifications
  - [x] 21.1 Filter assessment list based on scheme configuration
    - Show only enabled assessments
    - _Requirements: 5.1_
  - [x] 21.2 Add access control for disabled assessments
    - Redirect with message if accessing disabled assessment
    - _Requirements: 5.3_
  - [x] 21.3 Write property test for asesi content matches scheme
    - **Property 8: Asesi Content Matches Scheme**
    - **Validates: Requirements 5.2**

- [x] 22. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 6: Admin UI for Configuration

- [x] 23. Create Admin Skema Configuration Page
  - [x] 23.1 Create view for assessment tool configuration
    - Toggle switches for each assessment type
    - APL toggles disabled (always on)
    - _Requirements: 1.1_
  - [x] 23.2 Implement save configuration functionality
    - AJAX call to update configuration
    - Show success/error messages
    - _Requirements: 1.2, 1.4_

- [x] 24. Create Admin Asesor Assignment Page
  - [x] 24.1 Create view for asesor-scheme assignments
    - List of asesors with their assigned schemes
    - _Requirements: 3.1_
  - [x] 24.2 Implement assign scheme functionality
    - Modal or form to assign scheme to asesor
    - _Requirements: 3.2_
  - [x] 24.3 Implement revoke scheme functionality
    - Confirmation dialog before revoking
    - _Requirements: 3.3_

- [x] 25. Create Assessment Content Management Page
  - [x] 25.1 Create view for content listing per scheme
    - Filter by assessment type
    - _Requirements: 4.3_
  - [x] 25.2 Create form for adding new content
    - Support multiple choice, essay, practical task types
    - _Requirements: 4.1, 4.2_
  - [x] 25.3 Create form for editing content
    - Preserve scheme association
    - _Requirements: 4.4_
  - [x] 25.4 Implement delete content functionality
    - Confirmation dialog before deleting
    - _Requirements: 4.5_

- [x] 26. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 7: Default Configuration & Templates

- [x] 27. Implement default configuration on scheme creation
  - [x] 27.1 Add observer or event listener for Skema creation
    - Create default SkemaAssessmentConfig records
    - All assessments enabled by default
    - _Requirements: 7.1_
  - [x] 27.2 Write property test for default configuration
    - **Property 10: Default Configuration on New Scheme**
    - **Validates: Requirements 7.1**

- [x] 28. Implement template functionality (optional)
  - [x] 28.1 Create AssessmentConfigTemplate model
    - Store template configurations
    - _Requirements: 7.2_
  - [x] 28.2 Implement applyTemplate() in SkemaConfigService
    - Copy template config to scheme
    - _Requirements: 7.3_
  - [x] 28.3 Write property test for template application
    - **Property 11: Template Application Copies Configuration**
    - **Validates: Requirements 7.3**
  - [x] 28.4 Write property test for template isolation
    - **Property 12: Template Isolation**
    - **Validates: Requirements 7.4**

- [x] 29. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Phase 8: Data Migration & Backward Compatibility

- [x] 30. Create data migration for existing schemes
  - [x] 30.1 Create seeder for default assessment config
    - Generate config for all existing schemes
    - All assessments enabled by default
    - _Requirements: 7.1_
  - [x] 30.2 Verify existing progress data compatibility
    - Ensure existing progres_asesmen data works with new system
    - _Requirements: 8.4_
  - [x] 30.3 Write property test for historical progress retention
    - **Property 15: Historical Progress Retention**
    - **Validates: Requirements 8.4**

- [x] 31. Final Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.
