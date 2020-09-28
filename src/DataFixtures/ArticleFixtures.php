<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création de 3 catégorie
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

            $manager->persist($category);

            // Create entre 4 et 6 articles
            for($j = 1; $j <= random_int(4, 6); $j++) {

                $article = new Article();

                $content = '<p>'.join($faker->paragraphs(5), '</p><p>').'</p>';

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);
                        
                $manager->persist($article);

                // Commentaires de l'article
                for($k = 1; $k <= random_int(4, 10); $k++) {

                    $comment = new Comment();

                    $content = '<p>'.join($faker->paragraphs(2), '</p><p>').'</p>';

                    $days = (new \DateTime())->diff($article->getCreatedAt())->format('%a');

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreateAt($faker->dateTimeBetween('-'.$days.' days'))
                            ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
