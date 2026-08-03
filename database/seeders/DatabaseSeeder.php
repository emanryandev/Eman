<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\CvConfig;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Seed Projects
        Project::create([
            'title' => 'Serverless Image Processor',
            'category' => 'aws',
            'description' => 'AWS Lambda based image processing pipeline with S3 and SNS.',
            'role' => 'Cloud Architect',
            'tech_stack' => ['AWS Lambda', 'S3', 'Node.js', 'Terraform'],
            'repository_url' => 'https://github.com/example/repo',
            'live_url' => '#',
            'display_order' => 0,
            'status' => 'published',
            'ui_config' => ['enter_animation' => 'fade-in-up', 'hover_effect' => 'terminal-glow', 'duration_ms' => 800, 'delay_ms' => 100],
        ]);

        Project::create([
            'title' => 'K8s Auto-Scaling Cluster',
            'category' => 'k8s',
            'description' => 'Deployed a highly available Kubernetes cluster using EKS with Prometheus monitoring.',
            'role' => 'DevOps Engineer',
            'tech_stack' => ['Kubernetes', 'Docker', 'Prometheus', 'Helm'],
            'repository_url' => 'https://github.com/example/k8s',
            'live_url' => '#',
            'display_order' => 1,
            'status' => 'published',
            'ui_config' => ['enter_animation' => 'fade-in-up', 'hover_effect' => 'terminal-glow', 'duration_ms' => 800, 'delay_ms' => 200],
        ]);

        // Seed CV Config
        CvConfig::create([
            'is_active' => true,
            'personal_info' => [
                'full_name' => 'Eman Alaa',
                'title' => 'Senior Cloud Architect',
                'email' => 'contact@cloud-env.local',
                'phone' => '+1 234 567 890',
                'links' => [
                    ['label' => 'LinkedIn', 'value' => 'linkedin.com/in/cloud-engineer', 'icon' => 'fa-brands fa-linkedin'],
                    ['label' => 'GitHub', 'value' => 'github.com/cloud-engineer', 'icon' => 'fa-brands fa-github']
                ]
            ],
            'summary' => 'Innovative Cloud Engineer with experience designing scalable, highly available infrastructure on AWS and GCP. Proven track record in CI/CD implementation and Infrastructure as Code (IaC).',
            'skills' => [
                ['category' => 'Cloud Providers', 'keywords' => ['AWS (EC2, S3, RDS, Lambda)', 'GCP', 'Azure']],
                ['category' => 'DevOps & CI/CD', 'keywords' => ['Docker', 'Kubernetes', 'Jenkins', 'GitHub Actions']],
                ['category' => 'Infrastructure as Code', 'keywords' => ['Terraform', 'Ansible', 'CloudFormation']]
            ],
            'experience' => [
                [
                    'company' => 'Tech Corp Inc.',
                    'job_title' => 'Cloud Infrastructure Engineer',
                    'start_date' => '01/2021',
                    'end_date' => 'Present',
                    'location' => 'New York, NY',
                    'achievements' => [
                        'Reduced AWS costs by 30% through resource optimization.',
                        'Implemented zero-downtime deployment pipelines using Kubernetes.',
                        'Architected a multi-region disaster recovery strategy.'
                    ]
                ]
            ],
            'education' => [
                ['institution' => 'State University', 'degree' => 'B.S. in Computer Science', 'graduation_year' => '2019']
            ],
            'certifications' => [],
            'layout_preferences' => [
                'section_order' => ['summary', 'skills', 'experience', 'education', 'certifications'],
                'primary_color' => '#10b981',
                'font_family' => 'Inter'
            ]
        ]);

        // Seed Site Settings
        SiteSetting::create([
            'years_experience' => 5,
            'uptime_percentage' => 99,
            'hero_title_en' => 'Architecting Scalable Cloud Infrastructure',
            'hero_title_ar' => 'بناء بنية تحتية سحابية قابلة للتوسع',
            'about_en' => 'Cloud Engineer specializing in designing secure, scalable, and highly available environments.',
            'about_ar' => 'مهندسة سحابية متخصصة في تصميم وبناء بيئات عمل آمنة.',
            'currently_learning_name' => 'Rust',
            'currently_learning_icon' => 'fa-brands fa-rust',
            'profile_pic' => '/assets/images/profile.png',
            'core_skills' => [
                ['name' => 'AWS / GCP', 'icon' => 'fa-brands fa-aws', 'percent' => 90],
                ['name' => 'Terraform', 'icon' => 'fa-solid fa-code', 'percent' => 85]
            ],
            'hobbies' => [
                ['name' => 'Gaming', 'icon' => 'fa-solid fa-gamepad']
            ],
            'radar_skills' => [
                ['name' => 'Cloud (AWS/GCP)', 'percent' => 95],
                ['name' => 'Containers', 'percent' => 90],
                ['name' => 'CI/CD Pipelines', 'percent' => 95],
                ['name' => 'IaC (Terraform)', 'percent' => 85],
                ['name' => 'Security', 'percent' => 85]
            ],
            'whatsapp_number' => '1234567890',
            'testimonials' => [],
            'experience_journey' => [
                ['title' => 'Senior Cloud Engineer', 'date' => '2021 - Present', 'description' => 'Architecting scalable cloud infra.'],
                ['title' => 'DevOps Engineer', 'date' => '2019 - 2021', 'description' => 'Automated CI/CD pipelines.']
            ]
        ]);
    }
}
