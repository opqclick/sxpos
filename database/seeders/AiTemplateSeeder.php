<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AiTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            [
                'template_name'=>'return_note',
                'prompt'=>"rephrase this product return reason '##reason##' in  long description",
                'module'=>'return',
                'field_json'=>'{"field":[{"label":"Product return result ","placeholder":"e.g. size issue ","field_type":"textarea","field_name":"reason"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'staff_note',
                'prompt'=>"generate for employee note description about this product return reason '##reason##'",
                'module'=>'return',
                'field_json'=>'{"field":[{"label":"Product return result ","placeholder":"e.g. size issue ","field_type":"textarea","field_name":"reason"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'quotation_note',
                'prompt'=>"generate note for quotations ending notes for quotation with includes of this 'customer satisfication'",
                'module'=>'quotations',
                'field_json'=>'{"field":[{"label":"Include focusable keywords ","placeholder":"e.g. customer service ","field_type":"textarea","field_name":"reason"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'invoice_footer_title',
                'prompt'=>"Generate a invoice footer titles for an invoice type to ##type##.",
                'module'=>'invoice_footer',
                'field_json'=>'{"field":[{"label":"Invoice Footer Type","placeholder":"e.g.purchase, sale","field_type":"text_box","field_name":"type"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'invoice_footer_notes',
                'prompt'=>"Generate a invoice footer notes for an invoice footer title is ##title##.",
                'module'=>'invoice_footer',
                'field_json'=>'{"field":[{"label":"Invoice Footer Title","placeholder":"e.g.Invoice Accuracy","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'title',
                'prompt'=>"Generate a creative and engaging event title for an upcoming event. The event can be a ##type##. Please focus on creating a title that captures the essence of the event, sparks curiosity, and encourages attendance. Aim to make the title memorable, intriguing, and aligned with the purpose and theme of the event. Consider the target audience, event objectives, and any specific keywords or ideas you would like to incorporate",
                'module'=>'calendars',
                'field_json'=>'{"field":[{"label":"Specific type of event","placeholder":"e.g.conference, workshop, seminar","field_type":"text_box","field_name":"type"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'description',
                'prompt'=> "generate a captivating description for the event that title is ##title##  in that activities are ##description##.please highlights its purpose, activities, and the benefits of attending",
                'module'=>'calendars',
                'field_json'=>'{"field":[{"label":"Event topic","placeholder":"Employee Prefomance celebration ","field_type":"text_box","field_name":"title"},{"label":"Event activiteis","placeholder":"speech,presentation","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            
            [
                'template_name'=>'name',
                'prompt'=>"Create creative product names:  ##description##" ,
                'module'=>'product',
                'field_json'=>'{"field":[{"label":"Product Description","placeholder":"e.g.Food,Electronics,Book","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],            
            [
                'template_name'=>'description',
                'prompt'=>"Write a long creative product description for: ##title## \n\nTarget audience is: ##audience## \n\nUse this description: ##description## \n\nTone of generated text must be:\n ##tone_language## \n\n",
                'module'=>'product',
                'field_json'=>'{"field":[{"label":"Product name","placeholder":"e.g. VR, Honda","field_type":"text_box","field_name":"title"},{"label":"Audience","placeholder":"e.g. Women, Aliens","field_type":"text_box","field_name":"audience"},{"label":"Product Description","placeholder":"e.g. VR is an innovative device that can allow you to be part of virtual world","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'name',
                'prompt'=>"Generate a category name for a product in an ##product_name##, specifically related to ##instruction##.",
                'module'=>'category',
                'field_json'=>'{"field":[{"label":"Product name","placeholder":"e.g.Systems and Control,Energy Systems","field_type":"text_box","field_name":"product_name"},{"label":"Category Instruction","placeholder":"e.g.Book,Electronics","field_type":"textarea","field_name":"instruction"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'title',
                'prompt'=>"Generate a todo title for a ##description##.",
                'module'=>'todos',
                'field_json'=>'{"field":[{"label":"Todo Details","placeholder":"e.g.Design Approved","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'note',
                'prompt'=>"generate short catchy description  for expense of ##description##",
                'module'=>'expense',
                'field_json'=>'{"field":[{"label":"Expense detail ","placeholder":"e.g. 12 computer","field_type":"textarea","field_name":"description"}]} ',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'name',
                'prompt'=>"generate category name of expense that indule this thing ##keyword##",
                'module'=>'expense_category',
                'field_json'=>'{"field":[{"label":"Expense type/item ","placeholder":"e.g. computer","field_type":"textarea","field_name":"keyword"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            
            [
                'template_name'=>'name',
                'prompt'=>"Generate branch name for ##description##",
                'module'=>'branch',
                'field_json'=>'{"field":[{"label":"Branch Description","placeholder":"e.g.","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'description',
                'prompt'=>"Generate a  tiny notification message and include this esentail detail ##description##",
                'module'=>'notifications',
                'field_json'=>'{"field":[{"label":"Notification description","placeholder":"e.g. tommorow we have off","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'content',
                'prompt'=>"Generate a meeting notification message for an ##topic## meeting. Include the date, time, location, and a brief agenda with three key discussion points.",
                'module'=>'notification template',
                'field_json'=>'{"field":[{"label":"Notification Message","placeholder":"e.g.brief explanation of the purpose or background of the notification","field_type":"textarea","field_name":"topic"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            
            // [
            //     'template_name'=>'name',
            //     'prompt'=>"please suggest subscription plan  name  for this  :  ##description##  for my business",
            //     'module'=>'plan',
            //     'field_json'=>'{"field":[{"label":"What is your plan about?","placeholder":"e.g. Describe your plan details ","field_type":"textarea","field_name":"description"}]}',
            //     'is_tone'=>'0',
            //     "created_at" => date('Y-m-d H:i:s'),
            //     "updated_at" => date('Y-m-d H:i:s'),
            // ],
            // [
            //     'template_name'=>'description',
            //     'prompt'=>"please suggest subscription plan  description  for this  :  ##title##:  for my business",
            //     'module'=>'plan',
            //     'field_json'=>'{"field":[{"label":"What is your plan title?","placeholder":"e.g. Pro Resller,Exclusive Access","field_type":"text_box","field_name":"title"}]}',
            //     'is_tone'=>'1',
            //     "created_at" => date('Y-m-d H:i:s'),
            //     "updated_at" => date('Y-m-d H:i:s'),
            // ],
            // [
            //     'template_name'=>'name',
            //     'prompt'=>"give 10 catchy only name of Offer or discount Coupon for : ##keywords##",
            //     'module'=>'coupon',
            //     'field_json'=>'{"field":[{"label":"Seed words","placeholder":"e.g.coupon will provide you with a discount on your selected plan","field_type":"text_box","field_name":"keywords"}]}',
            //     'is_tone'=>'0',
            //     "created_at" => date('Y-m-d H:i:s'),
            //     "updated_at" => date('Y-m-d H:i:s'),
            // ],
            [
                'template_name'=>'meta_keywords',
                'prompt'=>"Write SEO meta title for:\n\n ##description## \n\nWebsite name is:\n ##title## \n\nSeed words:\n ##keywords## \n\n",
                'module'=>'seo',
                'field_json'=>'{"field":[{"label":"Website Name","placeholder":"e.g. Amazon, Google","field_type":"text_box","field_name":"title"},{"label":"Website Description","placeholder":"e.g. Describe what your website or business do","field_type":"textarea","field_name":"description"},{"label":"Keywords","placeholder":"e.g.  cloud services, databases","field_type":"text_box","field_name":"keywords"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'meta_description',
                'prompt'=>"Write SEO meta description for:\n\n ##description## \n\nWebsite name is:\n ##title## \n\nSeed words:\n ##keywords## \n\n",
                'module'=>'seo',
                'field_json'=>'{"field":[{"label":"Website Name","placeholder":"e.g. Amazon, Google","field_type":"text_box","field_name":"title"},{"label":"Website Description","placeholder":"e.g. Describe what your website or business do","field_type":"textarea","field_name":"description"},{"label":"Keywords","placeholder":"e.g.  cloud services, databases","field_type":"text_box","field_name":"keywords"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],[
                'template_name'=>'cookie_title',
                'prompt'=>"please suggest me cookie title for this ##description## website which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Website name or info","placeholder":"e.g. example website ","field_type":"textarea","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],[
                'template_name'=>'cookie_description',
                'prompt'=>"please suggest me  Cookie description for this cookie title ##title##  which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Cookie Title ","placeholder":"e.g. example website ","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'strictly_cookie_title',
                'prompt'=>"please suggest me only Strictly Cookie Title for this ##description## website which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Website name or info","placeholder":"e.g. example website ","field_type":"textarea","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'strictly_cookie_description',
                'prompt'=>"please suggest me Strictly Cookie description for this Strictly cookie title ##title##  which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Strictly Cookie Title ","placeholder":"e.g. example website ","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'more_information_description',
                'prompt'=>"I need assistance in crafting compelling content for my ##web_name## website's 'Contact Us' page of my website. The page should provide relevant information to users, encourage them to reach out for inquiries, support, and feedback, and reflect the unique value proposition of my business.",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Websit Name","placeholder":"e.g. example website ","field_type":"text_box","field_name":"web_name"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'content',
                'prompt'=>"generate email template for ##type##",
                'module'=>'email template',
                'field_json'=>'{"field":[{"label":"Email Type","placeholder":"e.g. new user,new client","field_type":"text_box","field_name":"type"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],



        ];
        Template::insert($template);
    }
}

