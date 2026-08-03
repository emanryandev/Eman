<?php
use App\Models\SiteSetting;

$settings = SiteSetting::first();
if (!$settings) {
    $settings = new SiteSetting();
}

$settings->experience_journey = [
    [
        'title' => 'Senior Cloud Architect',
        'company' => 'TechNova Solutions',
        'duration' => '2023 - Present',
        'description' => 'Architecting and maintaining highly available cloud infrastructure on AWS. Implemented GitOps workflows with ArgoCD and Kubernetes.'
    ],
    [
        'title' => 'DevOps Engineer',
        'company' => 'CloudFrontier Inc',
        'duration' => '2020 - 2023',
        'description' => 'Automated CI/CD pipelines using GitHub Actions and Jenkins. Migrated legacy monoliths to microservices.'
    ],
];

$settings->certifications = [
    [
        'name' => 'AWS Certified Solutions Architect – Professional',
        'issuer' => 'Amazon Web Services',
        'icon' => 'fa-brands fa-aws',
        'url' => '#'
    ],
    [
        'name' => 'Certified Kubernetes Administrator (CKA)',
        'issuer' => 'Cloud Native Computing Foundation',
        'icon' => 'fa-solid fa-dharmachakra',
        'url' => '#'
    ],
    [
        'name' => 'HashiCorp Certified: Terraform Associate',
        'issuer' => 'HashiCorp',
        'icon' => 'fa-solid fa-cube',
        'url' => '#'
    ],
];

$settings->tech_categories = [
    [
        'name' => 'Cloud Providers',
        'icon' => 'fa-solid fa-cloud',
        'skills' => ['AWS (EC2, S3, RDS, EKS)', 'Google Cloud Platform (GCP)', 'Azure']
    ],
    [
        'name' => 'Containers & Orchestration',
        'icon' => 'fa-brands fa-docker',
        'skills' => ['Docker', 'Kubernetes (K8s)', 'Helm', 'Docker Compose']
    ],
    [
        'name' => 'Infrastructure as Code (IaC)',
        'icon' => 'fa-solid fa-code',
        'skills' => ['Terraform', 'Ansible', 'CloudFormation']
    ],
    [
        'name' => 'CI/CD & Version Control',
        'icon' => 'fa-solid fa-code-branch',
        'skills' => ['GitHub Actions', 'Jenkins', 'GitLab CI', 'ArgoCD']
    ],
    [
        'name' => 'Monitoring & Observability',
        'icon' => 'fa-solid fa-chart-line',
        'skills' => ['Prometheus', 'Grafana', 'ELK Stack', 'Datadog']
    ],
];

$settings->testimonials = [
    [
        'client_name' => 'Ahmed Youssef',
        'client_role' => 'CTO at TechNova',
        'feedback' => 'Eman completely transformed our infrastructure. Deployments that used to take hours now take minutes, with zero downtime.'
    ],
    [
        'client_name' => 'Sarah Connor',
        'client_role' => 'Product Manager',
        'feedback' => 'Her expertise in AWS and Kubernetes saved us a lot of money and headaches. A true professional and problem solver.'
    ],
];

$settings->save();
echo "Settings updated successfully!\n";
