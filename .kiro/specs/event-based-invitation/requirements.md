# Requirements Document

## Introduction

This document specifies the requirements for the Event-Based Asesi Invitation System. This system replaces the current open registration flow with an admin-controlled invitation system where administrators manage event participants, send email invitations, and control access to certification assessments. The system ensures that only invited participants can register and participate in certification events.

## Glossary

- **Admin**: System administrator who manages events and participant invitations
- **Asesi**: Assessment participant/candidate who receives invitation and completes certification
- **Event**: A certification event with specific dates, location (TUK), and participant list
- **Skema**: Certification scheme/competency standard that asesi will be assessed against
- **Participant**: An asesi who has been invited to an event for a specific skema
- **Invitation**: Email notification sent to asesi with event and skema details
- **Event_Participant**: Database record linking asesi email, event, and skema
- **Surat_Penetapan**: Official participant appointment letter document
- **Google_OAuth**: Google authentication mechanism required for asesi login
- **Bulk_Input**: Feature allowing multiple email addresses to be added simultaneously
- **Registration_Flow**: Multi-step process where asesi completes profile and assessment data

## Requirements

### Requirement 1: Event Participant Management

**User Story:** As an admin, I want to manage event participants by adding and removing asesi emails with their assigned skema, so that I can control who is invited to each certification event.

#### Acceptance Criteria

1. WHEN an admin views an event detail page, THE System SHALL display a participant management interface
2. WHEN an admin adds a participant with email and skema, THE System SHALL create an Event_Participant record
3. WHEN an admin adds a participant, THE System SHALL validate that the email is not already registered in any event across the entire system
4. IF an email already exists in any event, THEN THE System SHALL reject the addition and display an error message indicating the email is already registered
5. WHEN an admin removes a participant from an event, THE System SHALL delete the Event_Participant record and revoke all access to that event
6. WHEN an admin views the participant list, THE System SHALL display email, assigned skema, and invitation status for each participant

### Requirement 2: Bulk Email Input Interface

**User Story:** As an admin, I want to add multiple participant emails at once using a bulk input interface, so that I can efficiently invite many participants without entering them one by one.

#### Acceptance Criteria

1. WHEN an admin accesses the bulk add interface, THE System SHALL display an input field that accepts comma-separated or space-separated email addresses
2. WHEN an admin types an email followed by comma or space, THE System SHALL convert the email into a visual badge
3. WHEN an admin types additional emails, THE System SHALL create additional badges for each valid email
4. WHEN an admin submits the bulk input, THE System SHALL validate each email address format
5. WHEN an admin submits the bulk input, THE System SHALL check each email against all existing Event_Participant records across all events
6. IF any email in the bulk input already exists in the system, THEN THE System SHALL reject the entire bulk operation and display which emails are duplicates
7. WHEN an admin removes a badge, THE System SHALL remove that email from the bulk input list
8. WHEN an admin selects a skema for bulk input, THE System SHALL assign that skema to all emails in the bulk input

### Requirement 3: Email Invitation Sending

**User Story:** As an admin, I want the system to automatically send email invitations to participants when they are added to an event, so that asesi receive notification and instructions to register.

#### Acceptance Criteria

1. WHEN an admin adds a new participant to an event, THE System SHALL send an invitation email to that participant's email address
2. WHEN an admin adds participants via bulk input, THE System SHALL send invitation emails to all newly added participants
3. WHEN an admin edits an existing participant (changes skema), THE System SHALL send an updated invitation email to that participant
4. WHEN an admin removes a participant, THE System SHALL NOT send any email notification
5. THE invitation email SHALL include event name, event dates, assigned skema, and login instructions
6. THE invitation email SHALL include a link to the Google OAuth login page

### Requirement 4: Surat Penetapan File Upload

**User Story:** As an admin, I want to upload an official participant appointment letter (Surat Penetapan) for each event, so that there is documentation of who is authorized to participate.

#### Acceptance Criteria

1. WHEN an admin creates or edits an event, THE System SHALL provide a file upload field for Surat_Penetapan
2. THE System SHALL accept PDF and image file formats (JPG, PNG) for Surat_Penetapan
3. WHEN an admin uploads a Surat_Penetapan file, THE System SHALL store the file and associate it with the event
4. WHEN an admin uploads a new Surat_Penetapan file for an event that already has one, THE System SHALL replace the existing file
5. THE Surat_Penetapan upload SHALL be optional and not required to create an event
6. WHEN an admin views an event with an uploaded Surat_Penetapan, THE System SHALL display a download link for the file

### Requirement 5: Google OAuth Authentication for Asesi

**User Story:** As an asesi, I want to log in using my Google account with the email that received the invitation, so that I can access the certification registration system securely.

#### Acceptance Criteria

1. WHEN an asesi accesses the login page, THE System SHALL display a Google OAuth login button
2. WHEN an asesi clicks the Google OAuth login button, THE System SHALL redirect to Google authentication
3. WHEN an asesi completes Google authentication, THE System SHALL retrieve the authenticated email address
4. WHEN an asesi logs in with Google, THE System SHALL check if the authenticated email exists in any Event_Participant record
5. IF the authenticated email does not exist in any Event_Participant record, THEN THE System SHALL display a warning message that the email is not registered for any event
6. IF the authenticated email exists in Event_Participant records, THEN THE System SHALL create or retrieve the user account and log them in
7. THE System SHALL NOT allow asesi to register or login without Google OAuth authentication

### Requirement 6: Uninvited User Access Prevention

**User Story:** As a system administrator, I want to prevent users who have not been invited by admin from accessing the registration system, so that only authorized participants can register for certification.

#### Acceptance Criteria

1. WHEN a user attempts to access the registration flow, THE System SHALL verify their email exists in Event_Participant records
2. IF a user's email does not exist in any Event_Participant record, THEN THE System SHALL display a message indicating they are not registered for any event
3. IF a user's email does not exist in any Event_Participant record, THEN THE System SHALL prevent access to all registration pages
4. WHEN a user's email exists in Event_Participant records, THE System SHALL allow access to the registration flow for their assigned event and skema
5. THE System SHALL NOT display any public registration or self-enrollment options

### Requirement 7: Pre-Populated Registration Flow

**User Story:** As an asesi, I want to complete my registration with event and skema already assigned, so that I only need to provide my personal information and assessment data.

#### Acceptance Criteria

1. WHEN an invited asesi accesses the registration flow, THE System SHALL pre-populate the event field with their assigned event
2. WHEN an invited asesi accesses the registration flow, THE System SHALL pre-populate the skema field with their assigned skema
3. THE System SHALL prevent asesi from changing the pre-populated event and skema fields
4. WHEN an asesi completes registration, THE System SHALL follow the existing registration flow including signature upload (user/persetujuan/ttd)
5. WHEN an asesi completes registration, THE System SHALL follow the existing APL-01 data entry flow (user/apl1/b1 and subsequent steps)
6. WHEN an asesi logs in with Google, THE System SHALL auto-populate name and email fields from Google account data
7. WHEN an asesi has already completed registration for their event, THE System SHALL redirect them to their assessment dashboard

### Requirement 8: Single Event Participation Constraint

**User Story:** As a system administrator, I want to ensure each email address can only be registered for one event across the entire system, so that participants do not have duplicate or conflicting registrations.

#### Acceptance Criteria

1. WHEN the system validates a new participant email, THE System SHALL check if the email exists in any Event_Participant record across all events
2. IF an email already exists in any Event_Participant record, THEN THE System SHALL reject the new participant addition
3. WHEN an admin attempts to add a duplicate email, THE System SHALL display an error message indicating the email is already registered in another event
4. THE System SHALL enforce this constraint for both individual participant additions and bulk additions
5. WHEN a participant is removed from an event, THE System SHALL allow that email to be added to a different event

### Requirement 9: Participant Edit and Update

**User Story:** As an admin, I want to edit existing participant details such as changing their assigned skema, so that I can correct mistakes or accommodate changes in certification plans.

#### Acceptance Criteria

1. WHEN an admin views the participant list for an event, THE System SHALL provide an edit action for each participant
2. WHEN an admin edits a participant, THE System SHALL allow changing the assigned skema
3. WHEN an admin changes a participant's skema, THE System SHALL update the Event_Participant record
4. WHEN an admin changes a participant's skema, THE System SHALL send an updated invitation email to the participant
5. THE System SHALL NOT allow changing the participant's email address through edit (must remove and re-add)

### Requirement 10: Event Participant List Display

**User Story:** As an admin, I want to view a comprehensive list of all participants for an event grouped by skema, so that I can see who is invited and their certification scheme assignments.

#### Acceptance Criteria

1. WHEN an admin views an event detail page, THE System SHALL display all participants for that event
2. THE System SHALL group participants by their assigned skema
3. FOR each participant, THE System SHALL display email address, assigned skema, invitation sent status, and registration completion status
4. WHEN an admin views the participant list, THE System SHALL provide actions to edit or remove each participant
5. THE System SHALL display a count of total participants and participants per skema

### Requirement 11: Legacy Registration Flow Removal

**User Story:** As a system administrator, I want to disable the old open registration system, so that all new registrations must go through the invitation-based flow.

#### Acceptance Criteria

1. THE System SHALL remove all public-facing registration forms that allow self-enrollment
2. THE System SHALL remove any routes or endpoints that allow asesi to register without an invitation
3. WHEN a user accesses old registration URLs, THE System SHALL redirect them to the login page
4. THE System SHALL maintain existing data for asesi who registered before this system change
5. THE System SHALL only allow new registrations through the admin invitation flow

### Requirement 12: Participant Access Revocation

**User Story:** As an admin, I want participant access to be immediately revoked when I remove them from an event, so that unauthorized users cannot access assessment materials.

#### Acceptance Criteria

1. WHEN an admin removes a participant from an event, THE System SHALL immediately delete their Event_Participant record
2. WHEN a removed participant attempts to access the assessment system, THE System SHALL deny access and display the not-registered message
3. WHEN a removed participant is currently logged in, THE System SHALL revoke their session on next page load
4. THE System SHALL maintain audit logs of participant removals including timestamp and admin who performed the action

### Requirement 13: Email Validation and Duplicate Prevention

**User Story:** As a system administrator, I want the system to validate email formats and prevent duplicate emails across all events, so that data integrity is maintained and participants are not confused by multiple invitations.

#### Acceptance Criteria

1. WHEN an admin enters an email address, THE System SHALL validate it follows standard email format (contains @ and valid domain)
2. WHEN an admin submits an invalid email format, THE System SHALL reject it and display a format error message
3. WHEN validating emails in bulk input, THE System SHALL check for duplicates within the same bulk input batch
4. IF the bulk input contains duplicate emails, THEN THE System SHALL reject the submission and highlight the duplicate emails
5. THE System SHALL perform case-insensitive email comparison when checking for duplicates
6. WHEN checking for existing emails, THE System SHALL search across all Event_Participant records in the entire database regardless of event
