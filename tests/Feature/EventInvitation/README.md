# Event-Based Invitation Integration Tests

This directory contains comprehensive integration tests for the Event-Based Asesi Invitation System.

## Test Files

### 1. CompleteParticipantFlowTest.php
Tests the complete participant addition flow from admin invitation through registration completion.

**Tests:**
- Complete end-to-end participant addition flow
- Duplicate email rejection across events
- Registered user redirect behavior
- Event and skema pre-population

**Validates Requirements:** 1.2, 3.1, 5.4, 5.6, 7.1, 7.4

### 2. BulkParticipantFlowTest.php
Tests bulk participant addition including email sending and validation.

**Tests:**
- Bulk email sending to all participants
- Same skema assignment for all bulk participants
- Duplicate detection within batch and across system
- Email format validation
- Email normalization (case-insensitive, trimming)
- Large batch handling (50+ participants)
- Atomic operation (all-or-nothing)

**Validates Requirements:** 2.4, 2.8, 3.2

### 3. ParticipantRemovalFlowTest.php
Tests participant removal and immediate access revocation.

**Tests:**
- Immediate access revocation upon removal
- Audit log creation
- Removed participant cannot access registration
- Email reuse after removal
- Removal for registered and pending participants
- Sequential removal of multiple participants
- Event isolation (removal doesn't affect other events)

**Validates Requirements:** 1.5, 12.1, 12.2, 12.3

### 4. UninvitedUserFlowTest.php
Tests access control for uninvited users.

**Tests:**
- Uninvited user rejection at login
- Uninvited user cannot access registration
- Invited user can access registration
- Case-insensitive email checking
- Multiple uninvited emails rejection
- Existing account without invitation
- Transition from uninvited to invited
- Cannot mark uninvited user as registered
- Error message display
- Domain variation handling

**Validates Requirements:** 5.5, 6.2, 6.3

### 5. FileUploadFlowTest.php
Tests Surat Penetapan file upload functionality.

**Tests:**
- Complete file upload flow
- PDF, JPG, PNG file uploads
- File replacement with old file deletion
- Event creation without file (optional)
- File addition to existing event
- Correct directory storage
- Multiple events with different files
- File size limit (5MB)
- File download accessibility
- File cleanup on event deletion
- Nullable path field

**Validates Requirements:** 4.2, 4.3, 4.4, 4.6

## Running the Tests

### Run all integration tests:
```bash
php artisan test tests/Feature/EventInvitation/
```

### Run specific test file:
```bash
php artisan test tests/Feature/EventInvitation/CompleteParticipantFlowTest.php
```

### Run specific test method:
```bash
php artisan test --filter=complete_participant_addition_flow_works_end_to_end
```

## Known Issues

### Database Migration Issue
The tests currently fail due to a pre-existing migration issue with SQLite compatibility:
- Migration `2025_12_22_075414_update_hasil_asesmen_add_belum_ada_hasil_status.php` uses MySQL-specific `MODIFY COLUMN` syntax
- This syntax is not compatible with SQLite (used for testing)
- This is a pre-existing issue in the codebase, not related to the integration tests

**Workaround:**
The migration needs to be updated to use Laravel's Schema Builder instead of raw SQL for cross-database compatibility:

```php
// Instead of:
DB::statement("ALTER TABLE hasil_asesmen MODIFY COLUMN status...");

// Use:
Schema::table('hasil_asesmen', function (Blueprint $table) {
    $table->enum('status', ['kompeten', 'tidak_kompeten', 'belum_ada_hasil'])
          ->default('belum_ada_hasil')
          ->change();
});
```

## Test Coverage

These integration tests provide comprehensive coverage of:
- ✅ Complete user flows from invitation to registration
- ✅ Bulk operations and atomic transactions
- ✅ Access control and authorization
- ✅ File upload and storage
- ✅ Email sending and validation
- ✅ Audit logging
- ✅ Edge cases and error conditions

## Dependencies

The tests use:
- Laravel's RefreshDatabase trait for database isolation
- Mail::fake() for email testing
- Storage::fake() for file upload testing
- Mockery for Google OAuth mocking
- Factory classes for test data generation

## Notes

- All tests use database transactions and are isolated from each other
- Tests clean up after themselves (no test data pollution)
- Tests validate both happy paths and error conditions
- Tests verify requirements traceability
