<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('choices')->truncate();
        DB::table('scene_steps')->truncate();
        DB::table('scenes')->truncate();
        DB::table('assets')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- assets テーブルのデータ ---
        DB::table('assets')->insert([
            [
                'id' => 1,
                'name' => '霧の森（基本背景）',
                'filename' => 'foggy-forest1.jpg',
                'type' => 'image',
                'created_at' => '2026-06-30 10:18:01',
                'updated_at' => '2026-06-30 10:18:01',
            ],
            [
                'id' => 2,
                'name' => '神秘の森（基本BGM）',
                'filename' => 'maou_bgm_healing17.mp3',
                'type' => 'bgm',
                'created_at' => '2026-06-30 10:18:33',
                'updated_at' => '2026-06-30 10:18:33',
            ],
            [
                'id' => 3,
                'name' => '茂みをガサガサ',
                'filename' => '茂みガサガサ.mp3',
                'type' => 'se',
                'created_at' => '2026-06-30 10:18:33',
                'updated_at' => '2026-06-30 10:18:33',
            ],
        ]);

        // --- scenes テーブルのデータ ---
        DB::table('scenes')->insert([
            [
                'id' => 1,
                'title' => '1-1.森を歩く',
                'created_at' => null,
                'updated_at' => '2026-07-07 10:11:32',
            ],
            [
                'id' => 4,
                'title' => '1-2.すやすや女性との会話',
                'created_at' => '2026-07-07 09:40:18',
                'updated_at' => '2026-07-07 10:13:10',
            ],
            [
                'id' => 5,
                'title' => '1-3.すやすや女性と解決へ',
                'created_at' => '2026-07-07 09:48:09',
                'updated_at' => '2026-07-07 10:15:45',
            ],
            [
                'id' => 6,
                'title' => '1-4-2.一人で走る',
                'created_at' => '2026-07-07 09:54:27',
                'updated_at' => '2026-07-07 09:55:31',
            ],
            [
                'id' => 7,
                'title' => '1-3-2.すやすや女性と寝る',
                'created_at' => '2026-07-07 10:04:44',
                'updated_at' => '2026-07-08 09:09:57',
            ],
            [
                'id' => 8,
                'title' => '1-4.すやすや女性と歩く',
                'created_at' => '2026-07-07 10:15:58',
                'updated_at' => '2026-07-07 10:16:30',
            ],
        ]);

        // --- scene_steps テーブルのデータ ---
        DB::table('scene_steps')->insert([
            [
                'id' => 1,
                'scene_id' => 1,
                'step_order' => 1,
                'text' => '私は歩いている。この霧に包まれた森の中。
どこへ向かうべきかは分からない。しかし足は迷いなく動く。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => null,
                'updated_at' => '2026-07-07 09:37:20',
            ],
            [
                'id' => 2,
                'scene_id' => 1,
                'step_order' => 2,
                'text' => '歩いていると、一人の女性を見つけた。
その女性は木陰で木の根を枕にして、すやすやと眠っている。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => null,
                'updated_at' => '2026-07-07 09:39:38',
            ],
            [
                'id' => 6,
                'scene_id' => 4,
                'step_order' => 1,
                'text' => '「あ、あの、すみません。ちょっとお聞きしたいことが」
私は女性に近づきながら声をかける。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:42:17',
                'updated_at' => '2026-07-07 09:42:17',
            ],
            [
                'id' => 7,
                'scene_id' => 4,
                'step_order' => 2,
                'text' => '「ううん……まだ眠いぃ……」
女性は夢うつつに返答する。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:44:00',
                'updated_at' => '2026-07-07 09:44:00',
            ],
            [
                'id' => 8,
                'scene_id' => 4,
                'step_order' => 3,
                'text' => '「私、ここがどこなのか分からないんです。知っているなら教えてほしいのですが」
「ここはぁ、私のお布団でぇ……ぐぅ……」',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:45:33',
                'updated_at' => '2026-07-07 09:45:33',
            ],
            [
                'id' => 9,
                'scene_id' => 4,
                'step_order' => 4,
                'text' => '「そうじゃなくて、この森のことです。私、気づいたらここにいて」
「あなたはぁ、眠くないのぉ……？ふぁーあぁ」
女性はだらしなく大あくびをする。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:47:34',
                'updated_at' => '2026-07-07 09:47:34',
            ],
            [
                'id' => 10,
                'scene_id' => 5,
                'step_order' => 1,
                'text' => '「眠くなんてありません。私はこの森を出ないといけないんですから」
「じゃあ森を出たらぁ、ぐっすり眠れるの……？」
女性の目が、ゆっくり開いていく。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:50:19',
                'updated_at' => '2026-07-07 09:50:19',
            ],
            [
                'id' => 11,
                'scene_id' => 5,
                'step_order' => 2,
                'text' => '「そ、そうかもしれません。だから、森を出る方法を教えてもらいたいんです」
「それならぁ……教えてあげてもぉ、いいのかなぁ」
女性はふらふらと立ち上がる。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:51:43',
                'updated_at' => '2026-07-07 09:51:43',
            ],
            [
                'id' => 12,
                'scene_id' => 5,
                'step_order' => 3,
                'text' => '「ここを出るにはぁ、管理人さんに案内してもらわないといけないのぉ……。森のどこかにいるはずだからぁ、一緒に探してあげるね……」
「あ、ありがとうございます」',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 09:53:39',
                'updated_at' => '2026-07-07 09:53:39',
            ],
            [
                'id' => 13,
                'scene_id' => 6,
                'step_order' => 1,
                'text' => '少し歩くと、音が聞こえた。
バサッと。
足音？何かが羽ばたいた？分からないが、落ち着かない気持ちになる。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => '茂みガサガサ.mp3',
                'created_at' => '2026-07-07 09:56:52',
                'updated_at' => '2026-07-07 09:57:38',
            ],
            [
                'id' => 14,
                'scene_id' => 6,
                'step_order' => 2,
                'text' => '私はとっさに走り出す。
「きゃっ」
木の根に躓いて転んでしまう。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => null,
                'created_at' => '2026-07-07 10:00:08',
                'updated_at' => '2026-07-07 10:00:08',
            ],
            [
                'id' => 15,
                'scene_id' => 6,
                'step_order' => 3,
                'text' => '立ち上がって辺りを窺うと、もう音はしなくなっていた。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => null,
                'created_at' => '2026-07-07 10:01:15',
                'updated_at' => '2026-07-07 10:01:15',
            ],
            [
                'id' => 16,
                'scene_id' => 7,
                'step_order' => 1,
                'text' => '「言われてみると、なんだかすごく眠いような」
「そうでしょぉ……一緒にお休みしましょ……」
女性に促されるまま、私は隣で横になる。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 10:08:14',
                'updated_at' => '2026-07-07 10:08:14',
            ],
            [
                'id' => 17,
                'scene_id' => 7,
                'step_order' => 2,
                'text' => 'いつの間にか眠ってしまったようだ。
どれくらいの時間が経ったのだろう。目を覚ますと、隣にいたはずの女性はいなくなっていた。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => 'maou_bgm_healing17.mp3',
                'se' => null,
                'created_at' => '2026-07-07 10:09:35',
                'updated_at' => '2026-07-07 10:09:35',
            ],
            [
                'id' => 18,
                'scene_id' => 8,
                'step_order' => 1,
                'text' => '少し歩くと、音が聞こえた。
バサッと。
足音？何か羽ばたいた？分からないが、落ち着かない気持ちになる。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => '茂みガサガサ.mp3',
                'created_at' => '2026-07-07 10:17:35',
                'updated_at' => '2026-07-07 10:17:35',
            ],
            [
                'id' => 19,
                'scene_id' => 8,
                'step_order' => 2,
                'text' => '前を歩く女性が止まった。
「い……いやああああああああ！！」
女性は急に叫び、走り出す。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => null,
                'created_at' => '2026-07-07 10:18:55',
                'updated_at' => '2026-07-07 10:18:55',
            ],
            [
                'id' => 20,
                'scene_id' => 8,
                'step_order' => 3,
                'text' => '「ちょ、ちょっと、どうしたんですか。今の音は」
追いかけながら尋ねるも、返事はない。
女性は一心不乱に走り続ける。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => null,
                'created_at' => '2026-07-07 10:20:10',
                'updated_at' => '2026-07-07 10:20:10',
            ],
            [
                'id' => 21,
                'scene_id' => 8,
                'step_order' => 4,
                'text' => '「ま、待って、きゃっ」
木の根に躓き、私は転ぶ。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => null,
                'created_at' => '2026-07-07 10:21:21',
                'updated_at' => '2026-07-07 10:21:21',
            ],
            [
                'id' => 22,
                'scene_id' => 8,
                'step_order' => 5,
                'text' => '顔を上げると、女性の姿はもう見えなくなっていた。
「なんなの、もう」
立ち上がって辺りを窺うも、もう音はしない。',
                'bg_image' => 'foggy-forest1.jpg',
                'bgm' => null,
                'se' => null,
                'created_at' => '2026-07-07 10:22:39',
                'updated_at' => '2026-07-07 10:22:39',
            ],
        ]);

        // --- choices テーブルのデータ ---
        DB::table('choices')->insert([
            [
                'id' => 1,
                'scene_id' => 1,
                'text' => '女性に話しかけてみよう',
                'next_scene_id' => 4,
                'min_energy_required' => 1,
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => -1,
                'alignment_change' => 1,
                'affection_change' => '0',
                'created_at' => null,
                'updated_at' => '2026-07-07 10:02:54',
            ],
            [
                'id' => 2,
                'scene_id' => 1,
                'text' => '無視して歩き続けよう',
                'next_scene_id' => 6,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => '0',
                'alignment_change' => '0',
                'affection_change' => '0',
                'created_at' => null,
                'updated_at' => '2026-07-07 10:03:52',
            ],
            [
                'id' => 24,
                'scene_id' => 7,
                'text' => '森を歩こう',
                'next_scene_id' => 6,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => '0',
                'alignment_change' => '0',
                'affection_change' => '0',
                'created_at' => '2026-07-07 10:11:08',
                'updated_at' => '2026-07-07 10:13:18',
            ],
            [
                'id' => 25,
                'scene_id' => 4,
                'text' => '眠いような気がする',
                'next_scene_id' => 7,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => 1,
                'alignment_change' => 1,
                'affection_change' => '0',
                'created_at' => '2026-07-07 10:14:29',
                'updated_at' => '2026-07-07 10:15:29',
            ],
            [
                'id' => 26,
                'scene_id' => 4,
                'text' => '眠くない',
                'next_scene_id' => 5,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => '0',
                'alignment_change' => '0',
                'affection_change' => '0',
                'created_at' => '2026-07-07 10:15:06',
                'updated_at' => '2026-07-07 10:15:06',
            ],
            [
                'id' => 27,
                'scene_id' => 8,
                'text' => '周りに気を付けながら歩こう（現在この先未実装により、最初に戻る）',
                'next_scene_id' => 1,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => '0',
                'alignment_change' => '0',
                'affection_change' => '0',
                'created_at' => '2026-07-07 10:23:26',
                'updated_at' => '2026-07-08 09:11:42',
            ],
            [
                'id' => 28,
                'scene_id' => 6,
                'text' => '周りに気を付けながら歩こう（現在この先未実装により、最初に戻る）',
                'next_scene_id' => 1,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => '0',
                'alignment_change' => '0',
                'affection_change' => '0',
                'created_at' => '2026-07-07 10:43:35',
                'updated_at' => '2026-07-08 09:12:19',
            ],
            [
                'id' => 29,
                'scene_id' => 5,
                'text' => '女性の後ろをついていく',
                'next_scene_id' => 8,
                'min_energy_required' => '0',
                'min_alignment_required' => null,
                'max_alignment_required' => null,
                'min_affection_required' => '0',
                'energy_change' => '0',
                'alignment_change' => '0',
                'affection_change' => '0',
                'created_at' => '2026-07-07 10:47:34',
                'updated_at' => '2026-07-07 10:47:34',
            ],
        ]);

    }
}
