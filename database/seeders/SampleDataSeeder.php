<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Discussion;
use App\Models\Masail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample books
        $book1 = Book::create([
            'title' => 'Fiqh Muamalah',
            'description' => 'Kitab yang membahas tentang hukum-hukum dalam bermuamalah antar sesama manusia, termasuk jual beli, sewa menyewa, dan lain-lain.'
        ]);

        $book2 = Book::create([
            'title' => 'Akidah Islamiyah',
            'description' => 'Kitab yang membahas tentang dasar-dasar kepercayaan dalam Islam, meliputi rukun iman dan hal-hal yang berkaitan dengan akidah.'
        ]);

        // Create chapters for book 1 with deeper hierarchy
        $chapter1 = Chapter::create([
            'book_id' => $book1->id,
            'title' => 'Bab Jual Beli',
            'description' => 'Pembahasan tentang hukum-hukum jual beli dalam Islam',
            'order' => 1
        ]);

        $chapter2 = Chapter::create([
            'book_id' => $book1->id,
            'parent_id' => $chapter1->id,
            'title' => 'Rukun dan Syarat Jual Beli',
            'description' => 'Sub bab yang membahas rukun dan syarat sahnya jual beli',
            'order' => 1
        ]);

        $chapter2_1 = Chapter::create([
            'book_id' => $book1->id,
            'parent_id' => $chapter2->id,
            'title' => 'Rukun Jual Beli',
            'description' => 'Penjelasan detail tentang rukun-rukun jual beli',
            'order' => 1
        ]);

        $chapter2_2 = Chapter::create([
            'book_id' => $book1->id,
            'parent_id' => $chapter2->id,
            'title' => 'Syarat Jual Beli',
            'description' => 'Penjelasan detail tentang syarat-syarat jual beli',
            'order' => 2
        ]);

        $chapter3 = Chapter::create([
            'book_id' => $book1->id,
            'parent_id' => $chapter1->id,
            'title' => 'Jual Beli yang Terlarang',
            'description' => 'Sub bab tentang berbagai bentuk jual beli yang dilarang',
            'order' => 2
        ]);

        $chapter4 = Chapter::create([
            'book_id' => $book1->id,
            'title' => 'Bab Sewa Menyewa',
            'description' => 'Pembahasan tentang hukum sewa menyewa (ijarah)',
            'order' => 2
        ]);

        $chapter5 = Chapter::create([
            'book_id' => $book1->id,
            'parent_id' => $chapter4->id,
            'title' => 'Rukun dan Syarat Ijarah',
            'description' => 'Sub bab tentang rukun dan syarat sewa menyewa',
            'order' => 1
        ]);

        // Create chapters for book 2 with hierarchy
        $chapter6 = Chapter::create([
            'book_id' => $book2->id,
            'title' => 'Bab Iman kepada Allah',
            'description' => 'Pembahasan tentang keimanan kepada Allah SWT',
            'order' => 1
        ]);

        $chapter7 = Chapter::create([
            'book_id' => $book2->id,
            'parent_id' => $chapter6->id,
            'title' => 'Asmaul Husna',
            'description' => 'Sub bab tentang nama-nama Allah yang indah',
            'order' => 1
        ]);

        $chapter8 = Chapter::create([
            'book_id' => $book2->id,
            'title' => 'Bab Iman kepada Malaikat',
            'description' => 'Pembahasan tentang keimanan kepada malaikat',
            'order' => 2
        ]);

        // Create discussions
        $discussion1 = Discussion::create([
            'chapter_id' => $chapter1->id,
            'title' => 'Definisi Jual Beli',
            'content' => 'Jual beli menurut bahasa adalah tukar menukar. Sedangkan menurut istilah syara adalah tukar menukar harta dengan harta lainnya dengan cara tertentu.',
            'order' => 1
        ]);

        $discussion2 = Discussion::create([
            'chapter_id' => $chapter2_1->id,
            'title' => 'Rukun Jual Beli',
            'content' => 'Rukun jual beli ada tiga: 1) Aqidain (dua pihak yang berakad), 2) Maqud alaih (barang yang diperjualbelikan), 3) Shighat (lafadz akad).',
            'order' => 1
        ]);

        $discussion3 = Discussion::create([
            'chapter_id' => $chapter4->id,
            'title' => 'Pengertian Ijarah',
            'content' => 'Ijarah adalah akad atas manfaat dengan imbalan. Ijarah dibagi menjadi dua: ijarah atas barang dan ijarah atas pekerjaan.',
            'order' => 1
        ]);

        $discussion4 = Discussion::create([
            'chapter_id' => $chapter6->id,
            'title' => 'Wujud Allah',
            'content' => 'Allah SWT adalah Dzat yang wajib wujud, tidak ada yang menyerupai-Nya dan Dia tidak menyerupai sesuatu.',
            'order' => 1
        ]);

        // Create masail
        $masail1 = Masail::create([
            'title' => 'Hukum Jual Beli dengan Sistem Kredit',
            'question' => 'Bagaimana hukum jual beli dengan sistem pembayaran kredit atau cicilan?',
            'description' => 'Masail tentang kebolehan jual beli dengan sistem pembayaran tidak tunai'
        ]);

        $masail2 = Masail::create([
            'title' => 'Jual Beli Barang yang Belum Ada',
            'question' => 'Apakah boleh menjual barang yang belum ada atau belum dikuasai?',
            'description' => 'Masail tentang jual beli barang yang belum wujud'
        ]);

        // Create relations between masail and discussions
        $masail1->discussions()->attach([$discussion1->id, $discussion2->id]);
        $masail2->discussions()->attach([$discussion1->id, $discussion3->id]);
    }
}
