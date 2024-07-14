<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\CourseUser;
use App\Models\DataPrivatCourse;
use App\Models\PacketClass;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Gede Hari Yoga Nanda',
            'email' => 'gede@gmail.com',
            'password' => Hash::make('password'),
            'institusi' => 'PENS',
            'roles' => 'admin',
            'phone_number' => '081234567890',
            'is_verified_register' => true,
        ]);

        User::create([
            'name' => 'Handaru Dwiking',
            'roles' => 'user',
            'email' => 'handaru@gmail.com',
            'password' => Hash::make('password'),
            'institusi' => 'PENS',
            'phone_number' => '081234567891',
            'is_verified_register' => true,
        ]);

        User::create([
            'name' => 'Iqbal',
            'roles' => 'user',
            'email' => 'iqbal@gmail.com',
            'password' => Hash::make('password'),
            'institusi' => 'PENS',
            'phone_number' => '081234567892',
            'is_verified_register' => true,
        ]);

        User::create([
            'name' => 'Firman',
            'roles' => 'user',
            'email' => 'firman@gmail.com',
            'password' => Hash::make('password'),
            'institusi' => 'ITS',
            'phone_number' => '081234567893',
            'is_verified_register' => false,
        ]);

        Course::create([
            'name_course' => 'Belajar Laravel',
            'slug_course' => 'belajar-laravel',
            'banner_course' => 'banner-course/laravel.jpeg',
            'instructor_course' => 'Gede Hari Yoga Nanda',
            'experiences_instructor_course' => 'Bekerja di Tokped 6 Tahun Sebagai Backend Developer',
            'description_course' => 'Belajar Laravel dari 0 sampe mahir',
            'category_course' => 'Online Course',
            'price_course' => 100000,
            'price_discount_course' => 50000,
            'is_free_course' => false,
        ]);

        Course::create([
            'name_course' => 'Belajar React',
            'slug_course' => 'belajar-react',
            'banner_course' => 'banner-course/react.jpeg',
            'instructor_course' => 'Agoeng',
            'experiences_instructor_course' => 'Bekerja di Tokped 6 Tahun Sebagai Frontend Developer',
            'description_course' => 'Belajar React dari 0 sampe mahir',
            'category_course' => 'Online Course',
            'price_course' => 50000,
            'price_discount_course' => 0,
            'is_free_course' => true,
        ]);

        Course::create([
            'name_course' => 'Belajar Mobile Developer Flutter',
            'slug_course' => 'belajar-mobile-developer-flutter',
            'banner_course' => 'banner-course/flutter.jpeg',
            'instructor_course' => 'Mahendra Khibrah',
            'experiences_instructor_course' => 'Bekerja di Tokped 6 Tahun Sebagai Mobile Developer',
            'description_course' => 'Belajar Flutter dari 0 sampe mahir',
            'category_course' => 'Online Course',
            'price_course' => 50000,
            'price_discount_course' => 20000,
            'is_free_course' => false,
        ]);

        Course::create([
            'name_course' => 'Bimbingan Belajar Pemrograman Eduskill',
            'slug_course' => 'bimbingan-belajar-pemrograman-eduskill',
            'banner_course' => 'banner-course/privat.jpg',
            'description_course' => 'Bimbingan Belajar Pemrograman Eduskill adalah bimbingan belajar pemrograman yang dilakukan secara privat',
            'category_course' => 'Private Course',
            'instructor_course' => 'Eduskill Teaching',
            'experiences_instructor_course' => '-',
        ]);

        CourseDetail::create([
            'course_id' => 1,
            'url_video_course' => 'https://www.youtube.com/embed/S5gENF1hLJw?si=Qvzkj-bA1HXb8ntZ&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin',
            'transkrip_course' => "duowowowowowowo intie ben jago qjhdawhdawd",
            'duration_course' => "00:22:04",
            'title_course' => "Pertemuan 1 - Laravel",
            'slug_course' => "pertemuan-1-laravel-adjahwd",
        ]);

        CourseDetail::create([
            'course_id' => 1,
            'url_video_course' => 'https://www.youtube.com/embed/essSvC96Ndo?si=Xayn8Xo_HkBx06lw&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin',
            'transkrip_course' => "duowowowowowowo intie ben jagojandandkawd ",
            'duration_course' => "00:05:06",
            'title_course' => "Pertemuan 2 - Laravel",
            'slug_course' => "pertemuan-2-laravel-adjahwd",
        ]);

        CourseDetail::create([
            'course_id' => 2,
            'url_video_course' => 'https://www.youtube.com/embed/RVH_5L5Lsp0?si=WDLFfg235QcG2dVd&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin',
            'transkrip_course' => "duowowowowowowo intie ben jago jdjawjdjqwjdw",
            'duration_course' => "00:27:17",
            'title_course' => "Pertemuan 1 - React Instalasi All Konfigurasi ",
            'slug_course' => "pertemuan-1-react-adjahwd",

        ]);

        CourseDetail::create([
            'course_id' => 3,
            'url_video_course' => 'https://www.youtube.com/embed/jYPsr5mcdS8?si=T4KPmCfZoCh9q2-9&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin',
            'transkrip_course' => "ben dowo iniadoa odidawiodawdhdhajdhawuhdawdhawdqwidaw",
            'duration_course' => "00:03:03",
            'title_course' => "Pertemuan 1 - Flutter Instalasi All Konfigurasi ",
            'slug_course' => "pertemuan-1-flutter-adjahwd",
        ]);

        CourseUser::create([
            'user_id' => 2,
            'course_id' => 2,
            'status_course' => "unlock",
        ]);

        CourseUser::create([
            'user_id' => 2,
            'course_id' => 3,
            'status_course' => "unlock",
        ]);

        PaymentGateway::create([
            'user_id' => 2,
            'course_id' => 1,
            'payment_method' => 'GOPAY',
            'payment_status' => 'success',
            'amount_payment' => 100000,
        ]);

        PaymentGateway::create([
            'user_id' => 2,
            'course_id' => 3,
            'payment_method' => 'DANA',
            'payment_status' => 'success',
            'amount_payment' => 50000,
        ]);

        DataPrivatCourse::create([
            'name' => 'guary',
            'email' => 'ariyoga@gmail.com',
            'major' => 'Teknik Informatika',
            'institusi' => 'PENS',
            'description_private_course' => 'Belajar Intensif Bahasa C untuk PostTest',
            'teaching_private_course' => 'Mahendra Khibrah',
            'description_teaching_private_course' => 'dari kelas 2D3IT A, PENS',
            'deal_price_private_course' => 100000,
            'salary_teaching' => 50000,
            'net_funds_course' => 50000,
        ]);

        DataPrivatCourse::create([
            'name' => 'Han',
            'email' => 'handaru_dwiking@gmail.com',
            'major' => 'Teknik Informatika',
            'institusi' => 'ITS',
            'description_private_course' => 'Belajar Intensif Laravel untuk PostTest',
            'teaching_private_course' => 'Gede Hari Yoga Nanda',
            'description_teaching_private_course' => 'dari kelas 2D3IT A, PENS, jago laravel',
            'deal_price_private_course' => 50000,
            'salary_teaching' => 20000,
            'net_funds_course' => 30000,
        ]);

        PacketClass::create([
            'tipe_packet_class' => 'individu',
            'name_packet_class' => 'Paket Coba-Coba',
            'price_packet_class' => "50000",
            'count_packet_class' => "1",
        ]);

        PacketClass::create([
            'tipe_packet_class' => 'individu',
            'name_packet_class' => 'Paket Ahli',
            'price_packet_class' => "40000",
            'count_packet_class' => "6",
        ]);

        PacketClass::create([
            'tipe_packet_class' => 'individu',
            'name_packet_class' => 'Paket Jawara',
            'price_packet_class' => "25000",
            'count_packet_class' => "12",
        ]);

        PacketClass::create([
            'tipe_packet_class' => 'bareng-besti',
            'name_packet_class' => 'Paket Duo',
            'price_packet_class' => "45000",
            'count_packet_class' => "8",
            'limit_participant_packet_class' => "2",
        ]);

        PacketClass::create([
            'tipe_packet_class' => 'bareng-besti',
            'name_packet_class' => 'Paket Trio',
            'price_packet_class' => "60000",
            'count_packet_class' => "8",
            'limit_participant_packet_class' => "3",
        ]);

        PacketClass::create([
            'tipe_packet_class' => 'bareng-besti',
            'name_packet_class' => 'Paket Squad',
            'price_packet_class' => "80000",
            'count_packet_class' => "8",
            'limit_participant_packet_class' => "5",
        ]);

        CourseUser::create([
            'user_id' => 3,
            'course_id' => 4,
            'status_course' => "unlock",
            'packet_class_id' => 2
        ]);

        PaymentGateway::create([
            'user_id' => 3,
            'course_id' => 4,
            'payment_method' => 'GOPAY',
            'payment_status' => 'success',
            'amount_payment' => 40000,
        ]);
    }
}
