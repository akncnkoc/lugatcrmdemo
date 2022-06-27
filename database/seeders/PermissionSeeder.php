<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_types = [
      'Anasayfa Kasaları Listele' => 'dashboard-safe-list',
      'Anasayfa Stoktaki Ürünleri Göster' => 'dashboard-show-stocked-products',
      'Anasayfa Sistemdeki Ürünleri Göster' => 'dashboard-show-in-system-products',
      'Anasayfa Müşterileri Göster' => 'dashboard-show-customers',
      'Anasayfa Personelleri Göster' => 'dashboard-show-staffs',
      'Anasayfa Tedarikçileri Göster' => 'dashboard-show-suppliers',
      'Anasayfa Faturaları Göster' => 'dashboard-show-invoices',
      'Anasayfa Ödenmesi Geçikmiş Tedarikçi Ödemesi Göster' => 'dashboard-show-delayed-unpaid-payments',
      'Anasayfa Bu Ay Tedarikçilere Ödenmesi Gereken Göster' => 'dashboard-show-payable-payments',
      'Anasayfa Tedarikçiler Toplam Ödenmesi Gereken Göster' => 'dashboard-show-total-payable-payments',
      'Anasayfa Gider Çizelgesi Göster' => 'dashboard-show-expense-chart',
      'Anasayfa Kasa Çizelgesi Göster' => 'dashboard-show-safe-chart',
      'Anasayfa Satışlarda Harcanılan Gider Göster' => 'dashboard-show-invoice-expense-chart',
      'Anasayfa Satışlarda Kazanılan Gelir Göster' => 'dashboard-show-invoice-product-chart',

      'Kasaları Listeleme' => 'safe-list',
      'Kasa Görüntüleme' => 'safe-show',
      'Kasa Oluşturma' => 'safe-create',
      'Kasa Düzenleme' => 'safe-update',
      'Kasa Silme' => 'safe-delete',
      'Kasa Kayıtlarını Görebilme' => 'safe-log-show',

      'Ürünleri Listeleme' => 'product-list',
      'Kritik Stoktaki Ürünleri Listeleme' => 'critical-product-list',
      'Ürün Görüntüleme' => 'product-show',
      'Ürün Oluşturma' => 'product-create',
      'Ürün Düzenleme' => 'product-update',
      'Ürün Silme' => 'product-delete',
      'Ürün Raporu Görme' => 'product-report',
      'Ürün Kopyalama' => 'product-copy',
      'Varyasyonlu Ürün Oluşturma' => 'variant-product-create',
      'Ürünleri İçeri Aktarma' => 'product-import',
      'Ürün Yazdırma' => 'product-print',

      'Toplu Ürün Güncelleme' => 'product-batch-operation',

      'Toplu İrsaliyeleri Listeleme' => 'bulk-waybill-list',
      'Toplu İrsaliye Görüntüleme' => 'bulk-waybill-show',
      'Toplu İrsaliye Oluşturma' => 'bulk-waybill-create',
      'Toplu İrsaliye Düzenleme' => 'bulk-waybill-update',
      'Toplu İrsaliye Silme' => 'bulk-waybill-delete',
      'Toplu İrsaliye Yazdırma' => 'bulk-waybill-print',

      'Faturaları Listeleme' => 'invoice-list',
      'Fatura Görüntüleme' => 'invoice-show',
      'Fatura Oluşturma' => 'invoice-create',
      'Fatura Düzenleme' => 'invoice-update',
      'Fatura Silme' => 'invoice-delete',
      'Fatura Tekil Yazdırma' => 'invoice-print-singular',
      'Fatura Çogul Yazdırma' => 'invoice-print-plural',

      'Giderleri Listeleme' => 'expense-list',
      'Gider Görüntüleme' => 'expense-show',
      'Gider Oluşturma' => 'expense-create',
      'Gider Düzenleme' => 'expense-update',
      'Gider Silme' => 'expense-delete',
      'Gider Genel Raporu Görme' => 'expense-report',
      'Gider Yazdırma' => 'expense-print',


      'Kargoları Listeleme' => 'cargo-list',
      'Kargo Görüntüleme' => 'cargo-show',
      'Kargo Oluşturma' => 'cargo-create',
      'Kargo Düzenleme' => 'cargo-update',
      'Kargo Silme' => 'cargo-delete',
      'Kargo Genel Raporu Görme' => 'cargo-report',
      'Kargo Yazdırma' => 'cargo-print',

      'Müşterileri Listeleme' => 'customer-list',
      'Müşteri Görüntüleme' => 'customer-show',
      'Müşteri Oluşturma' => 'customer-create',
      'Müşteri Düzenleme' => 'customer-update',
      'Müşteri Silme' => 'customer-delete',
      'Müşteri Genel Raporu Görme' => 'customer-report',
      'Müşteri Yazdırma' => 'customer-print',
      'Müşterileri Dışa Aktar' => 'customer-export',
      'Müşterileri İçeri Aktar' => 'customer-import',

      'Tedarikçileri Listeleme' => 'supplier-list',
      'Tedarikçi Görüntüleme' => 'supplier-show',
      'Tedarikçi Oluşturma' => 'supplier-create',
      'Tedarikçi Düzenleme' => 'supplier-update',
      'Tedarikçi Silme' => 'supplier-delete',
      'Tedarikçileri Yazrı' => 'supplier-print',
      'Tedarikçi Genel Raporu Görme' => 'supplier-report-general',
      'Tedarikçi Tekil Rapor Görme' => 'supplier-report-singular',

      'Tedarikçi Ödemesi Listeleme' => 'supplier-payment-list',
      'Tedarikçi Ödemesi Oluşturma' => 'supplier-payment-create',
      'Tedarikçi Ödemesi Düzenleme' => 'supplier-payment-update',
      'Tedarikçi Ödemesi Silme' => 'supplier-payment-delete',

      'Düzenli Tedarikçi Ödemesi Listeleme' => 'supplier-regular-payment-list',
      'Düzenli Tedarikçi Ödemesi Görüntüleme' => 'supplier-regular-payment-show',
      'Düzenli Tedarikçi Ödemesi Oluşturma' => 'supplier-regular-payment-create',
      'Düzenli Tedarikçi Ödemesi Düzenleme' => 'supplier-regular-payment-update',
      'Düzenli Tedarikçi Ödemesi Silme' => 'supplier-regular-payment-delete',


      'Düzenli Ödeme Listeleme' => 'regular-payment-list',
      'Düzenli Ödeme Görüntüleme' => 'regular-payment-show',
      'Düzenli Ödeme Oluşturma' => 'regular-payment-create',
      'Düzenli Ödeme Düzenleme' => 'regular-payment-update',
      'Düzenli Ödeme Silme' => 'regular-payment-delete',

      'Personelleri Listeleme' => 'staff-list',
      'Personel Görüntüleme' => 'staff-show',
      'Personel Oluşturma' => 'staff-create',
      'Personel Düzenleme' => 'staff-update',
      'Personel Silme' => 'staff-delete',
      'Personel Genel Raporu Görme' => 'staff-report',
      'Personelleri Yazdırma' => 'staff-print',

      'Personel Hakediş Listeleme' => 'staff-payment-list',
      'Personel Hakediş Görüntüleme' => 'staff-payment-show',
      'Personel Hakediş Oluşturma' => 'staff-payment-create',
      'Personel Hakediş Düzenleme' => 'staff-payment-update',
      'Personel Hakediş Silme' => 'staff-payment-delete',
      'Personel Hakediş Yazdırma' => 'staff-payment-print',

      'Personel Hakediş Tipi Listeleme' => 'staff-payment-type-list',
      'Personel Hakediş Tipi Görüntüleme' => 'staff-payment-type-show',
      'Personel Hakediş Tipi Oluşturma' => 'staff-payment-type-create',
      'Personel Hakediş Tipi Düzenleme' => 'staff-payment-type-update',
      'Personel Hakediş Tipi Silme' => 'staff-payment-type-delete',

      'Yazar Kasaları Listeleme' => 'cash-register-list',
      'Yazar Kasa Görüntüleme' => 'cash-register-show',
      'Yazar Kasa Oluşturma' => 'cash-register-create',
      'Yazar Kasa Düzenleme' => 'cash-register-update',
      'Yazar Kasa Silme' => 'cash-register-delete',

      'Firma Bilgileri Düzenleme' => 'edit-company-information',
      'Genel Ayarları Düzenleme' => 'edit-general-setting',


      'Gider Tipleri Listeleme' => 'expense-type-list',
      'Gider Tipi Oluşturma' => 'expense-type-create',
      'Gider Tipi Düzenleme' => 'expense-type-update',
      'Gider Tipi Silme' => 'expense-type-delete',

      'Ürün Tipleri Listeleme' => 'product-type-list',
      'Ürün Tipi Oluşturma' => 'product-type-create',
      'Ürün Tipi Düzenleme' => 'product-type-update',
      'Ürün Tipi Silme' => 'product-type-delete',

      'Kargo Türleri Listeleme' => 'cargo-type-list',
      'Kargo Türü Oluşturma' => 'cargo-type-create',
      'Kargo Türü Düzenleme' => 'cargo-type-update',
      'Kargo Türü Silme' => 'cargo-type-delete',

      'Kargo Şirketleri Listeleme' => 'cargo-companies-list',
      'Kargo Şirketi Oluşturma' => 'cargo-companies-create',
      'Kargo Şirketi Düzenleme' => 'cargo-companies-update',
      'Kargo Şirketi Silme' => 'cargo-companies-delete',

      'Düzenli Ödeme Tipleri Listeleme' => 'regular-payment-type-list',
      'Düzenli Ödeme Tipi Oluşturma' => 'regular-payment-type-create',
      'Düzenli Ödeme Tipi Düzenleme' => 'regular-payment-type-update',
      'Düzenli Ödeme Tipi Silme' => 'regular-payment-type-delete',

      'Müşteri Tipleri Listeleme' => 'customer-role-list',
      'Müşteri Tipi Oluşturma' => 'customer-role-create',
      'Müşteri Tipi Düzenleme' => 'customer-role-update',
      'Müşteri Tipi Silme' => 'customer-role-delete',

      'Personel Tipleri Listeleme' => 'staff-role-list',
      'Personel Tipi Oluşturma' => 'staff-role-create',
      'Personel Tipi Düzenleme' => 'staff-role-update',
      'Personel Tipi Silme' => 'staff-role-delete',

      'Ürün Varyasyon Tipleri Listeleme' => 'product-variant-list',
      'Ürün Varyasyon Tipi Oluşturma' => 'product-variant-create',
      'Ürün Varyasyon Tipi Düzenleme' => 'product-variant-update',
      'Ürün Varyasyon Tipi Silme' => 'product-variant-delete',

      'Kullanıcıları Listeleme' => 'user-list',
      'Kullanıcı Oluşturma' => 'user-create',
      'Kullanıcı Düzenleme' => 'user-update',
      'Kullanıcı Silme' => 'user-delete',

      'Kur Oranları Görme' => 'currency-list',
      'Kur Oranlarını Güncelleme' => 'currency-update'
    ];

        if (Permission::all()->isEmpty()) {
            foreach ($permission_types as $permission_type => $permission_value) {
                Permission::create([
          'name' => $permission_type,
          'slug' => $permission_value
        ]);
            }
        }
    }
}
