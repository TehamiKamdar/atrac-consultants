<?php

namespace App\Console\Commands;

use App\Models\country;
use App\Models\universities;
use App\Models\university;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Sitemap for Website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Started Generating Sitemap');
        $sitemap = Sitemap::create();
        $sitemap->add(Url::create(route('home'))->setLastModificationDate(now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1.0));
        $sitemap->add(Url::create(route('about'))->setLastModificationDate(now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.6));
        $sitemap->add(Url::create(route('blog'))->setLastModificationDate(now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.6));
        $sitemap->add(Url::create(route('contact'))->setLastModificationDate(now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.5));

        $countries = country::where('status', 'active')->get();
        foreach ($countries as $country) {
            $sitemap->add(Url::create(route('country-details', $country->slug))->setLastModificationDate($country->updated_at ?? now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8));
            $sitemap->add(Url::create(route('university.list', $country->slug))->setLastModificationDate($country->updated_at ?? now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8));
            $universities = university::where('country_id', $country->id)->get();
            foreach ($universities as $university) {
                $sitemap->add(Url::create(route('university.details', [
                    'name' => $country->slug,
                    'slug' => $university->slug,
                ]))->setLastModificationDate($university->updated_at ?? now())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8));
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        Log::info('Finished Generating Sitemap');
    }
}
