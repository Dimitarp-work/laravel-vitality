<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::whereIn('name', ['Emotional Wellbeing', 'Gentle Movement', 'Mindfulness', 'Rest', 'Nourishment', 'Balance'])->get()->keyBy('name');

        $articles = [
            [
                'title' => 'Fans Rejoice: The Long-Awaited Van Dobben Saté Croquet is Finally Here!',
                'content' => 'It\'s official! After months of anticipation, the Van Dobben Saté Croquet (20x 100 gr) is now available
                in our stores. Fans of this unique snack have been clamoring for its return, and we\'ve heard you loud and
                clear. This croquet combines the perfect blend of flavors, with a creamy satay filling wrapped in a crispy
                outer layer.
                "I couldn\'t believe it when I saw it back in stock!" said one excited customer. "I\'ve been waiting for
                this since last year. Now, my snack nights are complete."
                So don\'t wait too long—grab your Van Dobben Saté Croquet today and experience what all the hype is
                about. It\'s the perfect treat for parties, family gatherings, or even a cozy night in.',
                'published_at' => now()->subDays(10),
                'tags' => ['Emotional Wellbeing'],
            ],
            [
                'title' => 'Over 1,000 Happy Customers: A Milestone Worth Celebrating!',
                'content' => 'We are thrilled to announce that we have surpassed 1,000 happy customers! This incredible milestone is a
                testament to your loyalty and love for our wide selection of products, from Ultiem Bitterballen to the
                famous Frikandel Extra Ultiem.
                Our bestsellers this month include the Ultiem Vleeskroket (28x 100 gr) and the Van Lieshout Frikandel
                Bikfrik Speciaal. These products have been flying off the shelves thanks to their unbeatable taste and
                quality.
                Here\'s to growing our community even further. Stay tuned for more exciting products and exclusive
                offers. Thank you for choosing us as your snack partner!',
                'published_at' => now()->subDays(5),
                'tags' => ['Nourishment'],
            ],
            [
                'title' => 'Frikandel Showdown: Extra Ultiem vs. Van Lieshout',
                'content' => '
            It\'s the battle of the frikandels! In one corner, we have the Frikandel Extra Ultiem (40x 100 gr), known
            for its rich flavor and juicy texture. In the other corner, the Van Lieshout Frikandel Extra (40x 100 gr), a
            fan favorite with a perfectly balanced seasoning.
            After a blind taste test, the results were shockingly close. Many tasters praised the Ultiem for its
            luxurious taste, while others couldn\'t resist the nostalgic charm of Van Lieshout. Ultimately, both emerged
            as winners in their own right.
            Why choose one when you can enjoy both? Try them today and decide for yourself which frikandel deserves
            the crown!
        ',
                'published_at' => now()->subDays(7),
                'tags' => ['Mindfulness'],
            ],
            [
                'title' => 'Snack Spotlight: The Rise of Mini Bitterballen',
                'content' => '
            Mini bitterballen are taking the snack world by storm, and it\'s easy to see why. These bite-sized
            delights, like the Ultiem Bitterbal 20% (100x 20 gr), pack all the flavor of their larger counterparts into
            a convenient, poppable form.
            Perfect for parties, office gatherings, or a quick snack on the go, mini bitterballen are as versatile as
            they are delicious. Pair them with Elite Joppiesaus or Remia Kruidige Pindasaus for a flavor explosion.
            Try them at your next event and see why everyone is raving about this mini marvel. Warning: they
            disappear fast!
        ',
                'published_at' => now()->subDays(2),
                'tags' => ['Rest', 'Balance'],
            ],
        ];

        foreach ($articles as $data) {
            $tagsToAttach = $data['tags'] ?? [];
            unset($data['tags']);

            $article = Article::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'published_at' => $data['published_at'],
                'created_at' => $data['published_at'],
                'updated_at' => now(),
            ]);

            if ($tagsToAttach) {
                $tagIds = [];
                foreach ($tagsToAttach as $tagName) {
                    if (isset($tags[$tagName])) {
                        $tagIds[] = $tags[$tagName]->id;
                    }
                }
                $article->tags()->attach($tagIds);
            }
        }
    }
}
