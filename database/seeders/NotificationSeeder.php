<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationTemplates;
use App\Models\NotificationTemplateLangs;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = [
            'new_customer'=>'New Customer','new_vendor'=>'New Vendor','new_quotation'=>'New Quotation','new_sales'=>'New Sales','new_return'=>'New Return','new_purchase'=>'New Purchase'
        ];

        $defaultTemplate = [
            'new_customer' => [
            'variables' => '{
                "Customer Name":"customer_name",
                "Customer Email": "customer_email",
                "Customer Phone number": "customer_phone_number",
                "Company Name": "user_name",
                "App Name": "app_name"
                }',
                'lang' => [
                    'ar' => 'تم إنشاء عميل جديد بواسطة {user_name}.',
                    'da' => 'Ny bruger oprettet af {bruger_navn}.',
                    'de' => 'Neuer Benutzer erstellt von {Benutzername}.',
                    'en' => 'New Customer created by {user_name}.',
                    'es' => 'Nueva usuario creada por {nombre_usuario}.',
                    'fr' => 'Nouvel utilisateur créé par {Nom_utilisateur}.',
                    'it' => 'Nuovo utente creato da {user_name}.',
                    'ja' => 'によって作成された新しい顧客 {ユーザー名}.',
                    'nl' => 'Nieuwe gebruiker gemaakt door {gebruikersnaam}.',
                    'pl' => 'Nowy użytkownik utworzony przez {nazwa_użytkownika}.',
                    'ru' => 'Новый пользователь, созданный {имя_пользователя}.',
                    'pt' => 'Novo Usuário criado por {user_name}.',
                    'tr' => '{user_name} tarafından oluşturulan yeni İstemci.',
                    'he' => 'לקוח חדש נוצר על ידי {user_name}.',
                    'zh' => '由 {user_name} 创建的新客户.',
                    'pt-br' => 'Novo Usuário criado por {user_name}.',
                ]
            ],

            'new_vendor' => [
                'variables' => '{
                    "Vendor Name":"vendor_name",
                    "Vendor Email": "vendor_email",
                    "Vendor Phone number": "vendor_phone_number",
                    "Company Name": "user_name",
                    "App Name": "app_name"
                    }',
                    'lang' => [
                        'ar' => 'تم إنشاء بائع جديد بواسطة {user_name}.',
                        'da' => 'Ny leverandør oprettet af {bruger_navn}.',
                        'de' => 'Neuer Anbieter erstellt von {Benutzername}.',
                        'en' => 'New Vendor created by {user_name}.',
                        'es' => 'Nuevo proveedor creado por  {nombre_usuario}.',
                        'fr' => 'Nouveau fournisseur créé par {Nom_utilisateur}.',
                        'it' => 'Nuovo fornitore creato da {user_name}.',
                        'ja' => 'によって作成された新しいベンダー{ユーザー名}.',
                        'nl' => 'Nieuwe leverancier gemaakt door {gebruikersnaam}.',
                        'pl' => 'Nowy dostawca utworzony przez użytkownika {nazwa_użytkownika}.',
                        'ru' => 'Новый поставщик создан пользователем {имя_пользователя}.',
                        'pt' => 'Novo fornecedor criado por {user_name}.',
                        'tr' => '{user_name} tarafından oluşturulan yeni Satıcı.',
                        'he' => 'ספק חדש שנוצר על ידי {user_name}.',
                        'zh' => '由 {user_name} 创建的新供应商。',
                        'pt-br' => 'Novo fornecedor criado por {user_name}.',
                    ]
                ],

                'new_quotation' => [
                    'variables' => '{
                        "Quotation Date":"quotation_date",
                        "Quotation Reference No":"quotation_reference_no",
                        "Quotation Customers": "quotation_customers",
                        "Customer Email": "customer_email",
                        "Company Name": "user_name",
                        "App Name": "app_name"
                        }',
                        'lang' => [
                            'ar' => 'عرض أسعار جديد تم إنشاؤه بواسطة{user_name}',
                            'da' => 'Nyt tilbud oprettet af {bruger_navn}.',
                            'de' => 'Neues Angebot erstellt von {Benutzername}.',
                            'en' => 'New Quotation created by {user_name}.',
                            'es' => 'Nuevo presupuesto creado por {nombre_usuario}.',
                            'fr' => 'Nouveau devis créé par {Nom_utilisateur}.',
                            'it' => 'Neues Angebot erstellt von {user_name}.',
                            'ja' => 'によって作成された新しい見積もり{ユーザー名}.',
                            'nl' => 'Nieuwe offerte gemaakt door {gebruikersnaam}.',
                            'pl' => 'Nowa oferta utworzona przez {nazwa_użytkownika}.',
                            'ru' => 'Новая цитата создана {имя_пользователя}.',
                            'pt' => 'Nova cotação criada por {user_name}.',
                            'tr' => '{user_name} tarafından oluşturulan Yeni Fiyat Teklifi.',
                            'he' => 'הצעת מחיר חדשה שנוצרה על ידי {user_name}.',
                            'zh' => '由 {user_name} 创建的新报价。',
                            'pt-br' => 'Nova cotação criada por {user_name}.',
                        ]
                    ],

                    'new_sales' => [
                        'variables' => '{
                            "Customer Name": "customer_name",
                            "Customer Email": "customer_email",
                            "Company Name": "user_name",
                            "App Name": "app_name"
                            }',
                            'lang' => [
                                'ar' => 'تم إنشاء المبيعات الجديدة {customer_email} بواسطة {user_name}.',
                                'da' => 'Nyt salgs-{customer_email} oprettet af {bruger_navn}.',
                                'de' => 'Neue Verkäufe {customer_email} erstellt von {Benutzername}.',
                                'en' => 'New Sales {customer_email} created by {user_name}.',
                                'es' => 'Nuevas ventas {customer_email} creadas por {nombre_usuario}.',
                                'fr' => 'Nouvelles ventes {customer_email} créées par {Nom_utilisateur}.',
                                'it' => 'Nuova vendita {customer_email} creata da {user_name}.',
                                'ja' => 'によって作成された新しいセールス {customer_email} {ユーザー名}.',
                                'nl' => 'Nieuwe verkoop {customer_email} gemaakt door {gebruikersnaam}.',
                                'pl' => 'Nowa sprzedaż {customer_email} utworzona przez użytkownika {nazwa_użytkownika}.',
                                'ru' => 'Новые продажи {customer_email}, созданные {имя_пользователя}.',
                                'pt' => 'Novas vendas {customer_email} criadas por {user_name}.',
                                'tr' => '{user_name} tarafından oluşturulan {customer_email} Yeni Satış.',
                                'he' => 'מכירות חדשות {customer_email} שנוצרו על ידי {user_name}.',
                                'zh' => '由 {user_name} 创建的新销售 {customer_email}。',
                                'pt-br' => 'Novas vendas {customer_email} criadas por {user_name}.',
                            ]
                        ],

                        'new_return' => [
                            'variables' => '{
                                "Customer Name": "customer_name",
                                "Vendor Name": "vendor_name",
                                "Return Note":"return_note",
                                "Staff Note": "staff_note",
                                "Company Name": "user_name",
                                "App Name": "app_name"
                                }',
                                'lang' => [
                                    'ar' => 'عائد جديد تم إنشاؤه بواسطة {customer_name}{user_name}',
                                    'da' => 'Ny retur {customer_name} oprettet af {bruger_navn}.',
                                    'de' => 'Neue Rückgabe {customer_name} erstellt von {Benutzername}.',
                                    'en' => 'New Return {customer_name} created by {user_name}.',
                                    'es' => 'Nuevo retorno {customer_name} creado por {nombre_usuario}.',
                                    'fr' => 'Nouveau retour {customer_name} créé par {Nom_utilisateur}.',
                                    'it' => 'Nuovo reso {customer_name} creato da {user_name}.',
                                    'ja' => 'によって作成された新しい返品 {customer_name}{ユーザー名}.',
                                    'nl' => 'Nieuwe Return {customer_name} gemaakt door {gebruikersnaam}.',
                                    'pl' => 'Nowy zwrot {customer_name} utworzony przez {nazwa_użytkownika}.',
                                    'ru' => 'Новый Return {customer_name} создан {имя_пользователя}.',
                                    'pt' => 'Novo retorno {customer_name} criado por {user_name}.',
                                    'tr' => '{user_name} tarafından oluşturulan yeni {customer_name} İadesi.',
                                    'he' => 'החזרה חדשה {customer_name} נוצרה על ידי {user_name}.',
                                    'zh' => '由 {user_name} 创建的新退货 {customer_name}。',
                                    'pt-br' => 'Novo retorno {customer_name} criado por {user_name}.',
                                ]
                            ],

                            'new_purchase' => [
                                'variables' => '{
                                    "Vendor Name": "vendor_name",
                                    "Vendor Email": "vendor_email",
                                    "Company Name": "user_name",
                                    "App Name": "app_name"
                                    }',
                                    'lang' => [
                                        'ar' => 'عملية شراء جديدة تم إنشاؤها بواسطة {vendor_name}{user_name}.',
                                        'da' => 'Nyt køb {vendor_name} oprettet af {bruger_navn}.',
                                        'de' => 'Neuer Kauf {vendor_name} erstellt von {Benutzername}.',
                                        'en' => 'New Purchase {vendor_name} created by {user_name}.',
                                        'es' => 'Nueva compra {vendor_name} creada por {nombre_usuario}.',
                                        'fr' => 'Nouvel achat {vendor_name} créé par {Nom_utilisateur}.',
                                        'it' => 'Nuovo acquisto {vendor_name} creato da {user_name}.',
                                        'ja' => 'によって作成された新しい購入 {vendor_name}{ユーザー名}.',
                                        'nl' => 'Nieuwe aankoop {vendor_name} gemaakt door {gebruikersnaam}.',
                                        'pl' => 'Nowy zakup {vendor_name} utworzony przez {nazwa_użytkownika}.',
                                        'ru' => 'Новая покупка {vendor_name} создана {имя_пользователя}.',
                                        'pt' => 'Nova compra {vendor_name} criada por {user_name}.',
                                        'tr' => '{user_name} tarafından oluşturulan {vendor_name} adlı yeni Satın Alma.',
                                        'he' => 'רכישה חדשה {vendor_name} נוצרה על ידי {user_name}.',
                                        'zh' => '由 {user_name} 创建的新采购 {vendor_name}。',
                                        'pt-br' => 'Nova compra {vendor_name} criada por {user_name}.',
                                    ]
                                ],
            
        ];

    //   dd($defaultTemplate);

        $user = User::where('type','Super Admin')->first();

        foreach($notifications as $k => $n)
        {
            $ntfy = NotificationTemplates::where('slug',$k)->count();
            if($ntfy == 0)
            {
                $new = new NotificationTemplates();
                $new->name = $n;
                $new->slug = $k;
                $new->save();

                foreach($defaultTemplate[$k]['lang'] as $lang => $content)
                {
                    NotificationTemplateLangs::create(
                        [
                            'parent_id' => $new->id,
                            'lang' => $lang,
                            'variables' => $defaultTemplate[$k]['variables'],
                            'content' => $content,
                            'created_by' =>  1,
                        ]
                    );
                }
            }
        }
    }
}
