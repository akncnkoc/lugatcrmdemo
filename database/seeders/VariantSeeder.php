<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $variants = [
      ['name' => 'Boyut', 'variant_id' => 'empty'],
      ['name' => '80x150'],
      ['name' => '80x300'],
      ['name' => '100x200'],
      ['name' => '100x300'],
      ['name' => '120x170'],
      ['name' => '120x180'],
      ['name' => '160x230'],
      ['name' => '200x290'],
      ['name' => '240x340'],
      ['name' => '240x340'],
      ['name' => '200x290'],
      ['name' => '200x290'],
      ['name' => '200x300'],
      ['name' => '240x320'],
      ['name' => '100x187'],
      ['name' => '125x192'],
      ['name' => '127x185'],
      ['name' => '73x302'],
      ['name' => '75x300'],
      ['name' => '148x224'],
      ['name' => '147x218'],
      ['name' => '100x195'],
      ['name' => '150x225'],
      ['name' => '147x215'],
      ['name' => '73x120'],
      ['name' => '119x185'],
      ['name' => '121x205'],
      ['name' => '83x152'],
      ['name' => '52x192'],
      ['name' => '103x190'],
      ['name' => '80x120'],
      ['name' => '80x126'],
      ['name' => '120x190'],
      ['name' => '150x196'],
      ['name' => '106x165'],
      ['name' => '91x147'],
      ['name' => '88x130'],
      ['name' => '121x183'],
      ['name' => '121x176'],
      ['name' => 'Renk', 'variant_id' => 'empty'],
      ['name' => 'Açık galibarda',],
      ['name' => 'Açık Mavi',],
      ['name' => 'Açık Mor',],
      ['name' => 'Açık Turkuaz',],
      ['name' => 'Açık Yeşil',],
      ['name' => 'Açık Yeşil Sarı',],
      ['name' => 'Alev Kırmızısı',],
      ['name' => 'Alev Turuncusu',],
      ['name' => 'Alice Mavisi',],
      ['name' => 'Alizarin',],
      ['name' => 'Altuni',],
      ['name' => 'Ametist',],
      ['name' => 'Armut',],
      ['name' => 'Akuamarin',],
      ['name' => 'Asker Yeşili',],
      ['name' => 'Bakır',],
      ['name' => 'Barut',],
      ['name' => 'Bataklık',],
      ['name' => 'Bebek Mavisi',],
      ['name' => 'Bej',],
      ['name' => 'Beyaz',],
      ['name' => 'Bondi Mavisi',],
      ['name' => 'Bordo',],
      ['name' => 'Bronz',],
      ['name' => 'Buğday',],
      ['name' => 'Burgonya',],
      ['name' => 'Camgöbeği',],
      ['name' => 'Camgöbeği Mavisi',],
      ['name' => 'Çam Yeşili',],
      ['name' => 'Çay Yeşili',],
      ['name' => 'Çelik Mevisi',],
      ['name' => 'Çikolata',],
      ['name' => 'Çivit',],
      ['name' => 'Deniz Mavisi',],
      ['name' => 'Deniz Yeşili',],
      ['name' => 'Devedikeni',],
      ['name' => 'Eğrelti Yeşili',],
      ['name' => 'Elektrik Mavisi',],
      ['name' => 'Elektrik Yeşili',],
      ['name' => 'Elektrik Çivit',],
      ['name' => 'Elektrik Lime',],
      ['name' => 'Elektrik Mor',],
      ['name' => 'Falu Kırmızısı',],
      ['name' => 'Fildişi',],
      ['name' => 'Fransız Gülü',],
      ['name' => 'Galibarda',],
      ['name' => 'Gece Mavisi',],
      ['name' => 'Gök Mavisi',],
      ['name' => 'Gri',],
      ['name' => 'Gri-Kuşkonmaz',],
      ['name' => 'Gül',],
      ['name' => 'Gümüşi',],
      ['name' => 'Haki',],
      ['name' => 'Hardal',],
      ['name' => 'Havuç',],
      ['name' => 'Hororibiği',],
      ['name' => 'İlkbahar Yeşili',],
      ['name' => 'İslam Yeşili',],
      ['name' => 'İslam Yeşili',],
      ['name' => 'Kabak',],
      ['name' => 'Kahverengi',],
      ['name' => 'Zeytin Kahverengisi',],
      ['name' => 'Kahverengimsi',],
      ['name' => 'Kamuflaj Yeşili',],
      ['name' => 'Karanfil Pembesi',],
      ['name' => 'Karanfil',],
      ['name' => 'Kardinal',],
      ['name' => 'Karolina Mavisi',],
      ['name' => 'Kayısı',],
      ['name' => 'Kehribar',],
      ['name' => 'Kestane',],
      ['name' => 'Keten',],
      ['name' => 'Kırmızı',],
      ['name' => 'Kırmızımsı Kahverengi',],
      ['name' => 'Kırmızı Menekşe',],
      ['name' => 'Kiraz Kırmızısı',],
      ['name' => 'Klein Mavisi',],
      ['name' => 'Kobalt',],
      ['name' => 'Kobal Mavisi',],
      ['name' => 'Koyu Galibarda',],
      ['name' => 'Koyu Haki',],
      ['name' => 'Koyu Kahverengi',],
      ['name' => 'Koyu Kestane',],
      ['name' => 'Koyu Kırmızı',],
      ['name' => 'Koyu Kızıl Kahverengi',],
      ['name' => 'Koyu Leylak',],
      ['name' => 'Koyu Magenta',],
      ['name' => 'Koyu Mandalina',],
      ['name' => 'Koyu Mavi',],
      ['name' => 'Koyu Menekşe',],
      ['name' => 'Koyu Mercan',],
      ['name' => 'Koyu Mor',],
      ['name' => 'Koyu Pastel Yeşil',],
      ['name' => 'Koyu Pembe',],
      ['name' => 'Koyu Şeftali',],
      ['name' => 'Koyu Toz Mavi',],
      ['name' => 'Koyu Turkuaz',],
      ['name' => 'Koyu Yeşil',],
      ['name' => 'Kösele',],
      ['name' => 'Krem',],
      ['name' => 'Kum Kahverengisi',],
      ['name' => 'Kuşkonmaz',],
      ['name' => 'Lacivert',],
      ['name' => 'Lavanta',],
      ['name' => 'Lavanta Mavisi',],
      ['name' => 'Lavanta Pembesi',],
      ['name' => 'Lavanta Grisi',],
      ['name' => 'Lavanta Galibarda',],
      ['name' => 'Lavanta Mor',],
      ['name' => 'Lavanta Gül',],
      ['name' => 'Limoni',],
      ['name' => 'Açık Limon',],
      ['name' => 'Leylak',],
      ['name' => 'Lime',],
      ['name' => 'Mandalina',],
      ['name' => 'Malakit',],
      ['name' => 'Mavi',],
      ['name' => 'Menekşe',],
      ['name' => 'Menekşe Patlıcan',],
      ['name' => 'Mısır',],
      ['name' => 'Mor',],
      ['name' => 'Morsalkım',],
      ['name' => 'Nane Yeşili',],
      ['name' => 'Nar',],
      ['name' => 'Navajo Beyazı',],
      ['name' => 'Okul Otobüsü Sarısı',],
      ['name' => 'Orkide',],
      ['name' => 'Orman Yeşili',],
      ['name' => 'Parlak Mor',],
      ['name' => 'Pas',],
      ['name' => 'Pastel Pembe',],
      ['name' => 'Pastel Yeşili',],
      ['name' => 'Patlıcan',],
      ['name' => 'Pembe',],
      ['name' => 'Pembe Turuncu',],
      ['name' => 'Peygamber Çiçeği',],
      ['name' => 'Prusya Mavisi',],
      ['name' => 'Safran',],
      ['name' => 'Safir',],
      ['name' => 'Sarımsı Kahverengi',],
      ['name' => 'Sarımsı Pembe',],
      ['name' => 'Soytarı',],
      ['name' => 'Sarı',],
      ['name' => 'Siyah',],
      ['name' => 'Siyahımsı Koyu Kahverengi',],
      ['name' => 'Soluk Sarı',],
      ['name' => 'Şeftali',],
      ['name' => 'Şeftali Turuncu',],
      ['name' => 'Şeftali Sarı',],
      ['name' => 'Tarçın',],
      ['name' => 'Teal',],
      ['name' => 'Mam Toprak',],
      ['name' => 'Toz Mavi',],
      ['name' => 'Zeytuni',],
      ['name' => 'Turkuaz',],
      ['name' => 'Turuncu',],
      ['name' => 'Turuncumsu Sarı',],
      ['name' => 'Yeşil',],
      ['name' => 'Yeşil Sarı',],
      ['name' => 'Yonca Yeşili',],
      ['name' => 'Yosun Yeşili',],
      ['name' => 'Zümrüt Yeşili',],
      ['name' => 'Yanık Turuncu',],
      ['name' => 'Yanık Toprak',],
      ['name' => 'Kardinal',],
      ['name' => 'Şarap',],
      ['name' => 'Celadon',],
      ['name' => 'Berrak Mavi',],
      ['name' => 'Gök Mavisi',],
      ['name' => 'Gül',],
      ['name' => 'Mercan',],
      ['name' => 'Mercan Kırmızısı',],
      ['name' => 'Kıpkırmızı',],
      ['name' => 'Hile Mavisi',],
      ['name' => 'Altınımsı',],
      ['name' => 'Siğil Otu',],
      ['name' => 'Holivod Kırmızısı',],
      ['name' => 'Sıcak Magenta',],
      ['name' => 'Sıcak Pembe',],
      ['name' => 'Eternasyonal Turuncu',],
      ['name' => 'Yeşim',],
      ['name' => 'Orta Şarap',],
      ['name' => 'Orta Mor',],
      ['name' => 'Dağ Pembesi',],
      ['name' => 'Aşı Boyası',],
      ['name' => 'Eski Altın',],
      ['name' => 'Eski İplik',],
      ['name' => 'Eski Lavanta',],
      ['name' => 'Eski Gül',],
      ['name' => 'Donuk Turuncu',],
      ['name' => 'Papaya',],
      ['name' => 'Periwinkle',],
      ['name' => 'Pers Yeşili',],
      ['name' => 'Pers Mavisi',],
      ['name' => 'Pers Lacivert',],
      ['name' => 'Pers Pembesi',],
      ['name' => 'Pers Kırmızısı',],
      ['name' => 'Pers Gülü',],
      ['name' => 'Pers Yumurta Mavisi',],
      ['name' => 'Kraliyet Mavisi',],
      ['name' => 'Kırmızı Şarap',],
      ['name' => 'Deniz Kabuğu',],
      ['name' => 'Ayrık Sarı',],
      ['name' => 'Vurgun Pembe',],
      ['name' => 'Salamura Grisi',],
      ['name' => 'Tenne',],
      ['name' => 'Küçük Kara',],
      ['name' => 'Viridian',],
      ['name' => 'Zinnwaldite',],
      ['name' => 'Beden', 'variant_id' => 'empty'],
      ['name' => 'XXS'],
      ['name' => 'XS'],
      ['name' => 'S'],
      ['name' => 'M'],
      ['name' => 'L'],
      ['name' => 'XL'],
      ['name' => 'XXL'],
      ['name' => '3XL'],
      ['name' => '4XL'],
      ['name' => '5XL'],
      ['name' => '3-4 Yaş'],
      ['name' => '4-5 Yaş'],
      ['name' => '5-6 Yaş'],
      ['name' => '6-7 Yaş'],
      ['name' => '7-8 Yaş'],
      ['name' => '8-9 Yaş'],
      ['name' => '9-10 Yaş'],
      ['name' => '10-11 Yaş'],
      ['name' => '11-12 Yaş'],
      ['name' => '12-13 Yaş'],
      ['name' => '13-14 Yaş'],
      ['name' => '0-1 Ay'],
      ['name' => '1-3 Ay'],
      ['name' => '3-6 Ay'],
      ['name' => '6-9 Ay'],
      ['name' => '9-12 Ay'],
      ['name' => '12-18 Ay'],
      ['name' => '18-24 Ay'],
      ['name' => '24-36 Ay'],
      ['name' => 'Yenidoğan'],
      ['name' => 'Numara', 'variant_id' => 'empty'],
      ['name' => '26'],
      ['name' => '26.5'],
      ['name' => '27'],
      ['name' => '27.5'],
      ['name' => '28'],
      ['name' => '28.5'],
      ['name' => '29'],
      ['name' => '29.5'],
      ['name' => '30'],
      ['name' => '30.5'],
      ['name' => '31'],
      ['name' => '31.5'],
      ['name' => '32'],
      ['name' => '33'],
      ['name' => '33.5'],
      ['name' => '34'],
      ['name' => '35'],
      ['name' => '35.5'],
      ['name' => '36'],
      ['name' => '37'],
      ['name' => '37.5'],
      ['name' => '38'],
      ['name' => '38.7'],
      ['name' => '39'],
      ['name' => '39.3'],
      ['name' => '39.5'],
      ['name' => '40'],
      ['name' => '40.5'],
      ['name' => '41'],
      ['name' => '42'],
      ['name' => '42.5'],
      ['name' => '43'],
      ['name' => '44'],
      ['name' => '44.5'],
      ['name' => '45'],
      ['name' => '46'],
      ['name' => '46.5'],
      ['name' => '47'],
      ['name' => 'Miktar', 'variant_id' => 'empty'],
      ['name' => '75 ml.'],
      ['name' => '100 ml.'],
      ['name' => '200 ml.'],
      ['name' => '250 ml.'],
      ['name' => '500 ml.'],
      ['name' => '1 lt.'],
      ['name' => '125 gr.'],
      ['name' => '250 gr.'],
      ['name' => '60 gr.'],
    ];
    $beforeVariant = null;
    foreach ($variants as $variant){
      if (isset($variant['variant_id'])){
        $beforeVariant = null;
      }
      $createvariant = Variant::create([
        'name' => $variant['name'],
        'variant_id' => $beforeVariant
      ]);
      if ($beforeVariant == null)
        $beforeVariant = $createvariant->id;
    }
  }
}
