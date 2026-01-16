# Implementation Plan: Event-Based Asesi Invitation System

## Overview

This implementation plan breaks down the Event-Based Asesi Invitation System into discrete, manageable coding tasks. The system replaces open registration with an admin-controlled invitation system where administrators manage event participants, send email invitations, and control access to certification assessments.

## Tasks

- [x] 1. Create database migrations and models
  - Create migration for event_participants table with all required fields and constraints
  - Create migration to add surat_penetapan_path to event table
  - Create EventParticipant model with relationships and scopes
  - Update Event model with new relationship and methods
  - _Requirements: 1.1, 1.2, 4.1, 8.1_

- [ ]* 1.1 Write property test for EventParticipant model
  - **Property 2: Participant Creation**
  - **Validates: Requirements 1.2**

- [x] 2. Implement custom exception classes
  - Create DuplicateEmailException for email uniqueness violations
  - Create InvalidEmailException for email format errors
  - Create BulkOperationException for bulk operation failures
  - Create UnauthorizedAccessException for access control violations
  - _Requirements: 1.3, 2.4, 5.5, 6.2_

- [x] 3. Implement ParticipantManagementService
  - [x] 3.1 Implement addParticipant method with email validation and uniqueness check
    - Validate email format using filter_var
    - Check global email uniqueness across all events
    - Create EventParticipant record
    - _Requirements: 1.2, 1.3, 2.4, 13.1, 13.5_

- [ ]* 3.2 Write property tests for addParticipant
  - **Property 1: Email Global Uniqueness**
  - **Property 4: Email Format Validation**
  - **Property 35: Case-Insensitive Email Comparison**
  - **Validates: Requirements 1.3, 1.4, 2.4, 8.1, 8.2, 13.1, 13.5, 13.6**

- [x] 3.3 Implement addBulkParticipants method
  - Parse and normalize email array (trim, lowercase, unique)
  - Validate all email formats
  - Check for duplicates within batch
  - Check for duplicates in system
  - Create all participants in transaction
  - _Requirements: 2.4, 2.5, 2.6, 2.8, 13.3_

- [ ]* 3.4 Write property tests for addBulkParticipants
  - **Property 5: Bulk Duplicate Detection**
  - **Property 6: Bulk Atomic Operation**
  - **Property 7: Bulk Skema Assignment**
  - **Validates: Requirements 2.5, 2.6, 2.8, 13.3, 13.4**

- [x] 3.5 Implement updateParticipantSkema method
  - Find participant by ID
  - Update skema field
  - _Requirements: 9.2, 9.3_

- [ ]* 3.6 Write property tests for updateParticipantSkema
  - **Property 27: Skema Update**
  - **Property 28: Email Immutability in Edit**
  - **Validates: Requirements 9.2, 9.3, 9.5**

- [x] 3.7 Implement removeParticipant method
  - Find participant by ID
  - Log removal for audit trail
  - Delete participant record
  - _Requirements: 1.5, 12.1, 12.4_

- [ ]* 3.8 Write property tests for removeParticipant
  - **Property 3: Participant Deletion**
  - **Property 26: Email Reuse After Removal**
  - **Property 33: Removal Audit Logging**
  - **Validates: Requirements 1.5, 8.5, 12.1, 12.4**

- [x] 3.9 Implement helper methods
  - Implement emailExists method
  - Implement findDuplicateEmails method
  - Implement findBatchDuplicates method
  - Implement getParticipantsBySkema method
  - _Requirements: 1.3, 2.5, 10.2_

- [ ]* 3.10 Write property tests for helper methods
  - **Property 29: Participant Grouping by Skema**
  - **Property 30: Participant Count Accuracy**
  - **Validates: Requirements 10.2, 10.5**

- [ ] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 5. Implement EmailInvitationService
  - [x] 5.1 Implement sendInvitation method
    - Send invitation email using Mail facade
    - Update participant status to 'sent'
    - Update invitation_sent_at timestamp
    - _Requirements: 3.1, 3.2_

- [ ]* 5.2 Write property tests for sendInvitation
  - **Property 8: Invitation Email Sending**
  - **Property 9: Bulk Invitation Sending**
  - **Property 12: Invitation Email Content**
  - **Validates: Requirements 3.1, 3.2, 3.5, 3.6**

- [x] 5.3 Implement sendUpdatedInvitation method
  - Send updated invitation email
    - Update invitation_sent_at timestamp
    - _Requirements: 3.3, 9.4_

- [ ]* 5.4 Write property tests for sendUpdatedInvitation
  - **Property 10: Update Invitation Sending**
  - **Property 11: No Email on Removal**
  - **Validates: Requirements 3.3, 3.4, 9.4**

- [x] 6. Implement AccessControlService
  - [x] 6.1 Implement isEmailInvited method
    - Check if email exists in EventParticipant table
    - _Requirements: 5.4, 6.1_

- [x] 6.2 Implement getParticipantByEmail method
  - Retrieve participant with event and skema relationships
  - _Requirements: 5.4, 7.1, 7.2_

- [x] 6.3 Implement markAsRegistered method
  - Update invitation_status to 'registered'
  - Set registered_at timestamp
  - _Requirements: 7.7_

- [x] 6.4 Implement canAccessAssessment method
  - Check if user email has registered status
  - _Requirements: 6.3, 6.4_

- [ ]* 6.5 Write property tests for AccessControlService
  - **Property 17: Email Invitation Check**
  - **Property 18: Uninvited User Rejection**
  - **Property 19: Invited User Login**
  - **Property 20: Registration Access Control**
  - **Property 21: Authorized Registration Access**
  - **Validates: Requirements 5.4, 5.5, 5.6, 6.1, 6.2, 6.3, 6.4**

- [x] 7. Implement mail classes
  - [x] 7.1 Create AsesiInvitationMail mailable
    - Create markdown email template
    - Include event name, dates, skema, and login link
    - _Requirements: 3.5, 3.6_

- [x] 7.2 Create AsesiInvitationUpdatedMail mailable
  - Create markdown email template for updates
  - Include updated event and skema information
  - _Requirements: 3.3_

- [ ] 8. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 9. Implement Admin/EventParticipantController
  - [x] 9.1 Implement index method
    - Load event with participants grouped by skema
    - Load all skemas for dropdown
    - Return view with data
    - _Requirements: 1.1, 1.6, 10.1_

- [x] 9.2 Implement store method (single participant)
  - Validate request data
  - Call ParticipantManagementService->addParticipant
  - Handle exceptions and return appropriate responses
  - _Requirements: 1.2, 1.3, 1.4_

- [x] 9.3 Implement storeBulk method
  - Validate request data
  - Parse emails from comma/space-separated string
  - Call ParticipantManagementService->addBulkParticipants
  - Handle exceptions and return appropriate responses
  - _Requirements: 2.4, 2.5, 2.6, 2.8_

- [x] 9.4 Implement update method
  - Validate request data
  - Call ParticipantManagementService->updateParticipantSkema
  - Handle exceptions and return appropriate responses
  - _Requirements: 9.1, 9.2, 9.3, 9.4_

- [x] 9.5 Implement destroy method
  - Call ParticipantManagementService->removeParticipant
  - Handle exceptions and return appropriate responses
  - _Requirements: 1.5, 12.1_

- [x] 10. Implement Admin/EventController modifications
  - [x] 10.1 Implement uploadSuratPenetapan method
    - Validate file upload (PDF, JPG, PNG, max 5MB)
    - Delete old file if exists
    - Store new file in storage
    - Update event record
    - _Requirements: 4.2, 4.3, 4.4_

- [ ]* 10.2 Write property tests for file upload
  - **Property 13: File Format Validation**
  - **Property 14: File Storage and Association**
  - **Property 15: File Replacement**
  - **Property 16: Optional File Upload**
  - **Validates: Requirements 4.2, 4.3, 4.4, 4.5**

- [x] 10.3 Implement downloadSuratPenetapan method
  - Verify file exists
  - Return file download response
  - _Requirements: 4.6_

- [x] 11. Implement Auth/GoogleOAuthController
  - [x] 11.1 Implement redirectToGoogle method
    - Redirect to Google OAuth using Socialite
    - _Requirements: 5.1, 5.2_

- [x] 11.2 Implement handleGoogleCallback method
  - Retrieve Google user data
  - Check if email is invited using AccessControlService
  - Handle uninvited users with error message
  - Find or create user account
  - Update Google auth credentials
  - Login user
  - Check registration status and redirect appropriately
  - _Requirements: 5.3, 5.4, 5.5, 5.6, 7.6_

- [ ]* 11.3 Write property tests for Google OAuth flow
  - **Property 24: Google Data Auto-population**
  - **Validates: Requirements 5.3, 7.6**

- [ ] 12. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [-] 13. Implement Asesi/RegistrationController
  - [x] 13.1 Implement start method
    - Verify user is invited
    - Get participant details
    - Check if already registered
    - Load event and skema
    - Return registration view with pre-populated data
    - _Requirements: 6.1, 6.2, 7.1, 7.2, 7.7_

- [ ]* 13.2 Write property tests for registration flow
  - **Property 22: Event Pre-population**
  - **Property 23: Skema Pre-population**
  - **Property 25: Registered User Redirect**
  - **Validates: Requirements 7.1, 7.2, 7.3, 7.7**

- [x] 13.3 Implement complete method
  - Mark participant as registered
  - Redirect to assessment dashboard
  - _Requirements: 7.4, 7.5_

- [x] 14. Implement CheckAsesiInvitation middleware
  - Check if user is authenticated
  - Verify user email is invited
  - Check if user has completed registration
  - Redirect appropriately based on status
  - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5_

- [ ]* 14.1 Write property tests for middleware
  - **Property 31: Access Revocation After Removal**
  - **Property 32: Session Revocation**
  - **Validates: Requirements 12.2, 12.3**

- [x] 15. Create admin views for participant management
  - [x] 15.1 Create event-participants.blade.php
    - Display event details
    - Show participants grouped by skema
    - Add single participant form
    - Add bulk participant form with badge UI
    - Edit and delete actions for each participant
    - Upload Surat Penetapan form
    - _Requirements: 1.1, 1.6, 2.1, 2.2, 2.3, 4.1, 9.1, 10.1_

- [x] 15.2 Create participant list partial
  - Display participant table with email, skema, status
  - Show invitation status and registration status
  - Display participant counts
  - _Requirements: 1.6, 10.3, 10.5_

- [x] 15.3 Create bulk input component with badge UI
  - Input field that accepts comma/space-separated emails
  - Convert emails to visual badges on input
  - Allow badge removal
  - Skema selector for bulk operation
  - _Requirements: 2.1, 2.2, 2.3, 2.7, 2.8_

- [x] 16. Create asesi views for registration
  - [x] 16.1 Create registration/start.blade.php
    - Display event and skema information (read-only)
    - Show registration form with pre-populated fields
    - Include existing registration flow components
    - _Requirements: 7.1, 7.2, 7.3_

- [x] 16.2 Update login view
  - Add Google OAuth login button
  - Remove old registration links
  - _Requirements: 5.1, 11.1, 11.2_

- [x] 16.3 Create uninvited user message view
  - Display friendly error message
  - Provide contact information
  - _Requirements: 5.5, 6.2_

- [x] 17. Update routes
  - [x] 17.1 Add admin routes for participant management
    - GET /admin/events/{event}/participants
    - POST /admin/events/{event}/participants
    - POST /admin/events/{event}/participants/bulk
    - PUT /admin/events/{event}/participants/{participant}
    - DELETE /admin/events/{event}/participants/{participant}
    - _Requirements: 1.1, 1.2, 9.1, 9.2_

- [x] 17.2 Add admin routes for Surat Penetapan
  - POST /admin/events/{event}/surat-penetapan
  - GET /admin/events/{event}/surat-penetapan/download
  - _Requirements: 4.1, 4.6_

- [x] 17.3 Add Google OAuth routes
  - GET /auth/google
  - GET /auth/google/callback
  - _Requirements: 5.1, 5.2, 5.3_

- [x] 17.4 Add asesi registration routes
  - GET /asesi/registration/start (with middleware)
  - POST /asesi/registration/complete (with middleware)
  - _Requirements: 6.1, 7.1, 7.4_

- [x] 17.5 Remove old registration routes
  - Remove public registration endpoints
  - Add redirects to login page
  - _Requirements: 11.1, 11.2, 11.3_

- [x] 18. Apply middleware to protected routes
  - Apply CheckAsesiInvitation to all asesi routes
  - Apply auth middleware to registration routes
  - _Requirements: 6.1, 6.3, 6.4_

- [ ] 19. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 20. Create database factories and seeders
  - [x] 20.1 Create EventParticipantFactory
    - Generate random email, event, skema combinations
    - Support different invitation statuses

- [x] 20.2 Create EventParticipantSeeder
  - Seed sample participants for testing
  - Include various statuses and skemas

- [x] 21. Write integration tests
  - [x] 21.1 Test complete participant addition flow
    - Admin adds participant
    - Email is sent
    - Participant logs in via Google
    - Participant completes registration
    - _Requirements: 1.2, 3.1, 5.4, 5.6, 7.1, 7.4_

- [x] 21.2 Test bulk participant addition flow
  - Admin adds multiple participants via bulk
  - All emails are sent
  - All participants can log in
  - _Requirements: 2.4, 2.8, 3.2_

- [x] 21.3 Test participant removal flow
  - Admin removes participant
  - Participant loses access immediately
  - Logged-in participant session is revoked
  - _Requirements: 1.5, 12.1, 12.2, 12.3_

- [x] 21.4 Test uninvited user flow
  - User attempts Google login with uninvited email
  - System displays error message
  - User cannot access registration
  - _Requirements: 5.5, 6.2, 6.3_

- [x] 21.5 Test file upload flow
  - Admin uploads Surat Penetapan
  - File is stored correctly
  - Admin can download file
  - Admin replaces file
  - _Requirements: 4.2, 4.3, 4.4, 4.6_

- [ ] 22. Write unit tests for edge cases
  - [ ] 22.1 Test email validation edge cases
    - Empty string
    - Email with special characters
    - Very long email
    - Email without @ symbol
    - _Requirements: 2.4, 13.1, 13.2_

- [ ] 22.2 Test duplicate detection edge cases
  - Same email different case
    - Email with leading/trailing spaces
    - Duplicate within bulk batch
    - _Requirements: 13.3, 13.5_

- [ ] 22.3 Test file upload edge cases
  - File at exactly 5MB limit
  - Unsupported file type
  - Missing file
  - Corrupted file
  - _Requirements: 4.2_

- [x] 23. Update existing registration flow
  - [x] 23.1 Modify existing registration controllers
    - Pre-populate event and skema from session
    - Make event and skema fields read-only
    - Maintain existing flow logic
    - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5_
    - **Implementation**: Modified `PengajuanController::showDataSertifikasi()` to fetch EventParticipant data with eager-loaded skema relationship

- [x] 23.2 Update existing registration views
  - Display pre-populated event and skema
  - Disable field editing
  - Maintain existing UI/UX
  - _Requirements: 7.1, 7.2, 7.3_
    - **Implementation**: Updated `data-sertifikasi.blade.php` to:
      - Show info label when skema is from event invitation
      - Disable skema dropdown for event participants
      - Auto-select skema based on `$eventParticipant->id_skema`
      - Add hidden input to submit value (disabled fields don't submit)
      - Pre-populate nomor skema directly from server-side data
      - Auto-load unit kompetensi and dokumen SKKNI
      - Show SweetAlert info message for event participants

- [ ] 24. Final checkpoint - Ensure all tests pass
  - Run full test suite
  - Verify all property tests pass (100 iterations each)
  - Verify all unit tests pass
  - Verify all integration tests pass
  - Ask the user if questions arise

- [ ] 25. Documentation and cleanup
  - [ ] 25.1 Add inline code documentation
    - Document all service methods
    - Document all controller methods
    - Document all model relationships

- [ ] 25.2 Update API documentation
  - Document new endpoints
    - Document request/response formats
    - Document error codes

- [ ] 25.3 Create user guide
  - Admin guide for managing participants
  - Asesi guide for registration process

## Notes

- Tasks marked with `*` are optional property-based tests and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation
- Property tests validate universal correctness properties with 100 iterations each
- Unit tests validate specific examples and edge cases
- Integration tests validate end-to-end user flows
- The implementation follows Laravel best practices and MVC architecture
- All email addresses are stored and compared in lowercase for consistency
- File uploads are stored in the public disk under 'surat-penetapan' directory
- Google OAuth uses Laravel Socialite which is already installed
- The system enforces strict email uniqueness across all events globally
