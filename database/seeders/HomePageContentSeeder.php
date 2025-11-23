<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('home_page_contents')->insert([
            [
                'id' => 1,
                'section_key' => 'hero',
                'section_name' => 'Hero section',
                'content' => json_encode([
                    "title" => "Revolutionize Your Customer Support Experience",
                    "subtitle" => "AI-powered ticket management system that streamlines support, boosts productivity, and delights your customers with lightning-fast responses",
                    "cart_title" => "Smart Ticket Management",
                    "cart_subtitle" => "AI-powered routing and automated responses for efficient support",
                    "primary_button" => [
                        "text" => "View Pricing",
                        "url"  => "subscriptions"
                    ],
                    "secondary_button" => [
                        "text" => "Go to Dashboard",
                        "url"  => "tickets"
                    ]
                ]),
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => '2025-11-13 11:55:17',
                'updated_at' => '2025-11-14 00:33:57',
            ],

            [
                'id' => 2,
                'section_key' => 'features',
                'section_name' => 'Feature',
                'content' => json_encode([
                    "title" => "Everything You Need for Superior Support",
                    "subtitle" => "Powerful features that transform your customer support operations",
                    "items" => [
                        ["icon" => "fas fa-user-cog", "title" => "Account and Profile", "description" => "Easily set up, update, and customize your account details to enjoy a personalized support experience."],
                        ["icon" => "fas fa-ticket-alt", "title" => "Ticket Management System", "description" => "Create, track, and manage support tickets efficiently with real-time updates and smooth collaboration."],
                        ["icon" => "fas fa-comments", "title" => "Message & Live Chatting", "description" => "Communicate instantly with support agents through real-time messaging and seamless live chat."],
                        ["icon" => "fas fa-bolt", "title" => "Lightning Fast", "description" => "Instant ticket creation and real-time collaboration with live updates"],
                        ["icon" => "fas fa-brain", "title" => "Smart Automation", "description" => "AI-powered routing, response suggestions, and automated workflows"],
                        ["icon" => "fas fa-shield-alt", "title" => "Enterprise Security", "description" => "Bank-level security with end-to-end encryption and compliance"],
                    ]
                ]),
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => '2025-11-13 23:43:48',
                'updated_at' => '2025-11-15 03:29:04',
            ],

            [
                'id' => 3,
                'section_key' => 'stats',
                'section_name' => 'State',
                'content' => json_encode([
                    "items" => [
                        ["number" => 25000, "label" => "Tickets Processed", "icon" => "fas fa-check-double"],
                        ["number" => 99, "label" => "Customer Satisfaction", "icon" => "fas fa-smile"],
                        ["number" => 500, "label" => "Businesses Trust Us", "icon" => "fas fa-building"],
                        ["number" => 24, "label" => "Avg. Response Time (hrs)", "icon" => "fas fa-bolt"],
                    ]
                ]),
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => '2025-11-13 23:47:29',
                'updated_at' => '2025-11-14 00:49:43',
            ],

            [
                'id' => 4,
                'section_key' => 'contact',
                'section_name' => 'Contact',
                'content' => json_encode([
                    "title" => "Trusted by Industry Leaders",
                    "subtitle" => "See what our customers say...",
                    "items" => [
                        ["text" => "SupportPro transformed our...", "author" => "Sarah Johnson", "position" => "CTO, TechInnovate", "avatar" => "SJ"]
                    ]
                ]),
                'is_active' => 1,
                'sort_order' => 5,
                'created_at' => '2025-11-13 23:58:44',
                'updated_at' => '2025-11-13 23:58:44',
            ],

            [
                'id' => 5,
                'section_key' => 'plan',
                'section_name' => 'Plan',
                'content' => json_encode([
                    "title" => "Choose Your Subscription Plan",
                    "subtitle" => "Get access to live chat support with our flexible subscription plans",
                    "secondary_button" => ["text" => "Purchase"],
                    "primary_button" => ["text" => "View All Subscription plans", "url" => "/subscriptions"]
                ]),
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => '2025-11-14 00:57:01',
                'updated_at' => '2025-11-14 00:57:01',
            ],

            [
                'id' => 6,
                'section_key' => 'testimonials',
                'section_name' => 'Testimonials',
                'content' => json_encode([
                    "title" => "Trusted by Industry Leaders",
                    "subtitle" => "See what our customers say about their experience",
                    "items" => [
                        [
                            "text" => "SupportSystem transformed our customer service operations. Response times improved by 65% and customer satisfaction skyrocketed. The features are game-changing!",
                            "author" => "Sarah Johnson",
                            "position" => "CTO, TechInnovate",
                            "avatar" => "SJ"
                        ],
                        [
                            "text" => "The features are incredible! It suggests responses that are 90% accurate, saving our team hours every day. Implementation was smooth and support is excellent.",
                            "author" => "Mike Rodriguez",
                            "position" => "Support Manager, CloudScale",
                            "avatar" => "MR"
                        ],
                        [
                            "text" => "Implementation was seamless and the results were immediate. Our ticket resolution time dropped from 48 to 12 hours. The analytics dashboard is incredibly insightful.",
                            "author" => "Emily Parker",
                            "position" => "Operations Director, StartupGrid",
                            "avatar" => "EP"
                        ],
                    ]
                ]),
                'is_active' => 1,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
