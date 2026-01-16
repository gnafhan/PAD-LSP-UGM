# Task 1 Implementation Summary: Database Migrations and Models

## Overview
This document summarizes the implementation of Task 1 from the Event-Based Asesi Invitation System specification.

## Files Created

### 1. Database Migrations

#### `database/migrations/2025_01_15_000001_create_event_participants_table.php`
Creates the `event_participants` table with the following structure:
- **id**: Primary key (auto-increment)
- **id_event**: Foreign key to `event` table
- **id_skema**: Foreign key to `skema` table
- **email**: Participant email (indexed, unique across entire system)
- **invitation_status**: Enum ('pending', 'sent', 'registered')
- **invitation_sent_at**: Timestamp when invitation was sent
- **registered_at**: Timestamp when participant completed registration
- **timestamps**: created_at, updated_at

**Key Constraints:**
- Unique constraint on `email` (enforces global uniqueness across all events)
- Foreign key cascade delete on `id_event` and `id_skema`
- Composite index on `(id_event, id_skema)` for query optimization

#### `database/migrations/2025_01_15_000002_add_surat_penetapan_path_to_event_table.php`
Adds the `surat_penetapan_path` column to the `event` table:
- **surat_penetapan_path**: Nullable string to store file path for official appointment letter

### 2. Models

#### `app/Models/EventParticipant.php`
New model representing event participants with:

**Relationships:**
- `event()`: BelongsTo Event
- `skema()`: BelongsTo Skema
- `user()`: BelongsTo User (via email)

**Query Scopes:**
- `forEvent($eventId)`: Filter by event
- `forSkema($skemaId)`: Filter by skema
- `registered()`: Filter registered participants
- `pending()`: Filter pending/sent participants

**Casts:**
- `invitation_sent_at`: datetime
- `registered_at`: datetime

#### `app/Models/Event.php` (Modified)
Updated existing Event model with:

**New Fillable Field:**
- `surat_penetapan_path`

**New Relationships:**
- `participants()`: HasMany EventParticipant

**New Helper Methods:**
- `participantsBySkema()`: Returns participants grouped by skema
- `getParticipantCount()`: Returns total participant count
- `getRegisteredCount()`: Returns registered participant count

### 3. Factory

#### `database/factories/EventParticipantFactory.php`
Factory for testing with:

**States:**
- `sent()`: Marks invitation as sent
- `registered()`: Marks participant as registered
- `withEmail($email)`: Sets specific email
- `forEvent($eventId)`: Sets specific event
- `forSkema($skemaId)`: Sets specific skema

### 4. Seeder

#### `database/seeders/EventParticipantSeeder.php`
Sample seeder that creates three participants with different statuses:
- Pending participant
- Sent invitation participant
- Registered participant

## Running the Migrations

To apply these migrations to your database:

```bash
# Run all pending migrations
php artisan migrate

# Or run specific migrations
php artisan migrate --path=database/migrations/2025_01_15_000001_create_event_participants_table.php
php artisan migrate --path=database/migrations/2025_01_15_000002_add_surat_penetapan_path_to_event_table.php
```

## Running the Seeder

To seed sample data:

```bash
php artisan db:seed --class=EventParticipantSeeder
```

## Usage Examples

### Creating a Participant

```php
use App\Models\EventParticipant;

$participant = EventParticipant::create([
    'id_event' => 'EVENT202500001',
    'id_skema' => 'SKEMA202500001',
    'email' => 'participant@example.com',
    'invitation_status' => 'pending',
]);
```

### Using Factory in Tests

```php
use App\Models\EventParticipant;

// Create a pending participant
$participant = EventParticipant::factory()->create();

// Create a registered participant
$registered = EventParticipant::factory()->registered()->create();

// Create participant for specific event
$participant = EventParticipant::factory()
    ->forEvent('EVENT202500001')
    ->forSkema('SKEMA202500001')
    ->create();
```

### Querying Participants

```php
use App\Models\Event;
use App\Models\EventParticipant;

// Get all participants for an event
$event = Event::find('EVENT202500001');
$participants = $event->participants;

// Get participants grouped by skema
$grouped = $event->participantsBySkema();

// Get participant counts
$totalCount = $event->getParticipantCount();
$registeredCount = $event->getRegisteredCount();

// Query with scopes
$registered = EventParticipant::forEvent('EVENT202500001')->registered()->get();
$pending = EventParticipant::forSkema('SKEMA202500001')->pending()->get();
```

### Uploading Surat Penetapan

```php
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

$event = Event::find('EVENT202500001');

// Store file
$path = $request->file('surat_penetapan')->store('surat-penetapan', 'public');

// Update event
$event->update(['surat_penetapan_path' => $path]);

// Download file
if ($event->surat_penetapan_path && Storage::exists($event->surat_penetapan_path)) {
    return Storage::download($event->surat_penetapan_path);
}
```

## Requirements Validated

This implementation satisfies the following requirements from the specification:

- **Requirement 1.1**: Event participant management interface foundation
- **Requirement 1.2**: Create Event_Participant record
- **Requirement 4.1**: Surat Penetapan file upload field
- **Requirement 8.1**: Email uniqueness validation across system

## Next Steps

The following tasks can now be implemented:
- Task 2: Implement custom exception classes
- Task 3: Implement ParticipantManagementService
- Task 5: Implement EmailInvitationService
- Task 6: Implement AccessControlService

## Notes

- The database connection must be available to run migrations
- The unique constraint on `email` enforces global uniqueness across all events
- All email addresses should be stored in lowercase for consistency
- The factory includes helpful states for testing different scenarios
- The Event model now has convenient methods for working with participants
