<?php

namespace Database\Factories;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 画像サイズを指定
        $width = 500;
        $height = 500;
        // 画像を保存してpathを取得
        $file = $this->faker->image(null, $width, $height);
        $path = Storage::putFile('articles', $file);
        File::delete($file);

        return [
            'article_id' => \App\Models\Article::Factory()->create(),
            'org_name' => basename($file),
            'name' => basename($path),
        ];
    }
}
