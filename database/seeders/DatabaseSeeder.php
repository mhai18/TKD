<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Committee;
use App\Models\Chapter;
use App\Models\Player;
use App\Models\KyorugiTournament;
use App\Enums\UserType;
use App\Enums\Religion;
use App\Enums\CivilStatus;
use App\Enums\BeltLevel;
use App\Models\EventCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const DEFAULT_LOCATION = [
        'province_code' => 837,
        'municipality_code' => 83703,
        'brgy_code' => 83703005,
    ];

    public function run(): void
    {
        $this->call([
            RegionsTableSeeder::class,
            ProvincesTableSeeder::class,
            MunicipalitiesTableSeeder::class,
            BrgysTableSeeder::class,
        ]);

        // Create specific users and roles
        $this->createUser(UserType::ADMIN->value, 'admin@example.com', '09171234567', 'admin123');

        $chairman = $this->createUserWithCommittee(UserType::CHAIRMAN->value, 'chairman@example.com', '09181112222');
        $tm = $this->createUserWithCommittee(UserType::TOURNAMENT_MANAGER->value, 'tm@example.com', '09992223333');

        $coach1 = $this->createUserWithCommittee(UserType::COACH->value, 'coach1@example.com', '09171239999');
        $coach2 = $this->createUserWithCommittee(UserType::COACH->value, 'coach2@example.com', '09171238888');

        // Create chapters
        $chapter1 = $this->createChapter($coach1->id, 'Alpha Chapter');
        $chapter2 = $this->createChapter($coach2->id, 'Beta Chapter');

        // Create players
        $this->createPlayers($coach1, $chapter1, 4);
        $this->createPlayers($coach2, $chapter2, 4);

        // Create Event Category and Tournament
        $eventCategory = EventCategory::firstOrCreate(['name' => 'Kyorugi']);
        $this->createTournament($eventCategory->id, $tm->id);
    }

    private function createUser($userType, string $email, string $contactNumber, string $password): User
    {
        return User::factory()->create([
            'user_type' => $userType,
            'email' => $email,
            'contact_number' => $contactNumber,
            'password' => Hash::make($password),
        ]);
    }

    private function createUserWithCommittee($userType, string $email, string $contactNumber): User
    {
        $memberId = strtoupper(Str::random(8));
        $user = $this->createUser($userType, $email, $contactNumber, $memberId);

        Committee::create(array_merge([
            'user_id' => $user->id,
            'member_id' => $memberId,
            'birth_date' => now()->subYears(rand(10, 18)),
            'gender' => ['Male', 'Female'][rand(0, 1)],
            'civil_status' => CivilStatus::SINGLE,
            'belt_level' => BeltLevel::WHITE,
            'religion' => Religion::RC,
        ], self::DEFAULT_LOCATION));

        return $user;
    }

    private function createChapter(int $coachId, string $chapterName): Chapter
    {
        return Chapter::create(array_merge([
            'coach_id' => $coachId,
            'chapter_name' => $chapterName,
            'date_started' => now()->subYears(rand(1, 3)),
        ], self::DEFAULT_LOCATION));
    }

    private function createPlayers(User $coach, Chapter $chapter, int $count): void
    {
        foreach (range(1, $count) as $_) {
            $memberId = strtoupper(Str::random(8));
            $user = User::factory()->create([
                'user_type' => UserType::PLAYER,
                'password' => Hash::make($memberId),
            ]);

            Player::create(array_merge([
                'user_id' => $user->id,
                'coach_id' => $coach->id,
                'chapter_id' => $chapter->id,
                'member_id' => $memberId,
                'birth_date' => now()->subYears(rand(10, 18)),
                'gender' => ['Male', 'Female'][rand(0, 1)],
                'civil_status' => CivilStatus::SINGLE,
                'belt_level' => BeltLevel::WHITE,
                'religion' => Religion::RC,
            ], self::DEFAULT_LOCATION));
        }
    }

    private function createTournament(int $eventCategoryId, int $createdBy): void
    {
        KyorugiTournament::create(array_merge([
            'event_category_id' => $eventCategoryId,
            'name' => 'Kyorugi Nationals 2025',
            'start_date' => now()->addDays(30),
            'registration_start' => now(),
            'registration_end' => now()->addDays(20),
            'venue_name' => 'National Gym',
            'created_by' => $createdBy,
        ], self::DEFAULT_LOCATION));
    }
}
