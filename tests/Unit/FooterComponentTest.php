<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterComponentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function footer_contains_copyright_information()
    {
        $this->get('/')
            ->assertSee('© 2024 My Projeception. Tous droits réservés.');
    }

    /** @test */
    public function footer_contains_mentions_legales_link()
    {
        $this->get('/')
            ->assertSee('<a href="/mentions-legales">Mentions légales</a>');
    }

    /** @test */
    public function footer_contains_politique_confidentialite_link()
    {
        $this->get('/')
            ->assertSee('<a href="/politique-confidentialite">Politique de confidentialité</a>');
    }

    /** @test */
    public function footer_contains_laravel_version_information()
    {
        $this->get('/')
            ->assertSee('Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})');
    }
}
