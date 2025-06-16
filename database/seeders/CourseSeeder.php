<?php
namespace Database\Seeders;

use App\Models\Course;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Courses
        $guitarCourse = Course::create([
            'name'        => 'Kelas Gitar Dasar',
            'description' => 'Belajar bermain gitar dari dasar hingga mahir',
            'is_active'   => true,
        ]);

        $pianoCourse = Course::create([
            'name'        => 'Kelas Piano Pemula',
            'description' => 'Pelajari teknik dasar bermain piano',
            'is_active'   => true,
        ]);

        $drumsCourse = Course::create([
            'name'        => 'Kelas Drum Modern',
            'description' => 'Menguasai teknik drum untuk berbagai genre musik',
            'is_active'   => true,
        ]);

        // Create Tests for Guitar Course
        $guitarTest = Test::create([
            'course_id'        => $guitarCourse->id,
            'title'            => 'Test Teori Musik Dasar',
            'description'      => 'Test pemahaman teori musik dasar untuk gitar',
            'duration_minutes' => 30,
            'passing_score'    => 70,
        ]);

        // Create Questions for Guitar Test
        TestQuestion::create([
            'test_id'        => $guitarTest->id,
            'question'       => 'Berapa jumlah senar pada gitar klasik?',
            'options'        => ['4', '5', '6', '7'],
            'correct_answer' => '6',
            'order'          => 1,
        ]);

        TestQuestion::create([
            'test_id'        => $guitarTest->id,
            'question'       => 'Apa nama teknik memetik senar gitar dengan jari?',
            'options'        => ['Picking', 'Strumming', 'Fingerpicking', 'Hammering'],
            'correct_answer' => 'Fingerpicking',
            'order'          => 2,
        ]);

        TestQuestion::create([
            'test_id'        => $guitarTest->id,
            'question'       => 'Chord G Mayor terdiri dari nada apa saja?',
            'options'        => ['G-B-D', 'G-C-E', 'G-A-D', 'G-B-E'],
            'correct_answer' => 'G-B-D',
            'order'          => 3,
        ]);

        // Create Test for Piano Course
        $pianoTest = Test::create([
            'course_id'        => $pianoCourse->id,
            'title'            => 'Test Dasar Piano',
            'description'      => 'Test pemahaman dasar bermain piano',
            'duration_minutes' => 25,
            'passing_score'    => 75,
        ]);

        TestQuestion::create([
            'test_id'        => $pianoTest->id,
            'question'       => 'Berapa jumlah tuts putih pada piano standar?',
            'options'        => ['48', '52', '56', '60'],
            'correct_answer' => '52',
            'order'          => 1,
        ]);

        TestQuestion::create([
            'test_id'        => $pianoTest->id,
            'question'       => 'Apa nama teknik dasar posisi jari di piano?',
            'options'        => ['Fingering', 'Scaling', 'Touching', 'Pressing'],
            'correct_answer' => 'Fingering',
            'order'          => 2,
        ]);
    }
}
