<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverKeys;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExpenseTest extends DuskTestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function test_user_can_show_expenses(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('expense.index')
        ->assertSee('Gider Listesi')
        ->storeConsoleLog('expense_index_log')
        ->pause(2000);
        });
    }

    /**
     * @throws \Throwable
     */
    public function test_user_can_add_expense(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->refresh()
        ->waitUntilMissing('.page-loading')
        ->assertMissing('.page-loading')
        ->pause(2000)
        ->click("#createbutton")
        ->waitForText("Gider Ekle")
        ->keys('#create_form input[name="price"]', [WebDriverKeys::LEFT_CONTROL . "a" . WebDriverKeys::DELETE], "50000")
        ->pause(2000)
        ->value('#create_form input[name="date"]', date('d-m-Y'))
        ->pause(2000)
        ->keys('#create_form textarea[name="comment"]', [WebDriverKeys::LEFT_CONTROL . "a" . WebDriverKeys::DELETE], "Yorum")
        ->pause(2000)
        ->select2("#create_form .expense_type_id_select", "Hamal")
        ->assertSeeIn('#create_form .expense_type_id_select + .select2', 'Hamal')
        ->assertValue('#create_form input[name="date"]', date('d-m-Y'))
        ->assertValue('#create_form input[name="price"]', "500,00")
        ->select2("#create_form .safe_id_select", "EURO")
        ->assertSeeIn('#create_form .safe_id_select + .select2', 'EURO')
        ->assertValue('#create_form textarea[name="comment"]', "Yorum")
        ->click("#create_form button[type='submit']")
        ->pause(3000);
        });
    }

    /**
     * @throws \Throwable
     */
    public function test_user_can_update_expense(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->refresh()
        ->waitUntilMissing('.page-loading')
        ->assertMissing('.page-loading')
        ->pause(2000)
        ->click("[data-edit-button='12']")
        ->pause(2000)
        ->waitForText("Gider Düzenle")
        ->keys('#edit_form input[name="price"]', [WebDriverKeys::LEFT_CONTROL . "a" . WebDriverKeys::DELETE], "70000")
        ->pause(2000)
        ->keys('#edit_form input[name="date"]', [WebDriverKeys::LEFT_CONTROL . "a" . WebDriverKeys::DELETE], date('d-m-Y'))
        ->pause(2000)
        ->keys('#edit_form textarea[name="comment"]', [WebDriverKeys::LEFT_CONTROL . "a" . WebDriverKeys::DELETE], "Yeni Yorum Geldi")
        ->pause(2000)
        ->select2(".expense_type_id_edit_select", "Hamal")
        ->assertSeeIn('.expense_type_id_edit_select + .select2', 'Hamal')
        ->assertValue('#edit_form input[name="date"]', date('d-m-Y'))
        ->assertValue('#edit_form input[name="price"]', "700,00")
        ->select2(".safe_id_edit_select", "EURO")
        ->assertSeeIn('.safe_id_edit_select + .select2', 'EURO')
        ->assertValue('#edit_form textarea[name="comment"]', "Yeni Yorum Geldi")
        ->click("#edit_form button[type='submit']");
        });
    }
}
