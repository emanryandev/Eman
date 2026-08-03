<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $cvData['personal_info']['full_name'] ?? 'CV' }}</title>
    <style>
        body { margin: 0; padding: 0; background: #525659; display: flex; justify-content: center; }
        .a4-paper { 
            background: #fff; 
            width: 210mm; 
            min-height: 297mm; 
            padding: 15mm; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.3); 
            font-family: '{{ $cvData['layout_preferences']['font_family'] ?? 'Helvetica' }}', Arial, sans-serif; 
            color: #000; 
            direction: ltr; 
            text-align: left; 
            margin: 20px 0;
            box-sizing: border-box;
        }
        .a4-header { border-bottom: 3px solid {{ $cvData['layout_preferences']['primary_color'] ?? '#000' }}; padding-bottom: 15px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 24pt; }
        h2 { 
            color: {{ $cvData['layout_preferences']['primary_color'] ?? '#000' }}; 
            border-bottom: 2px solid {{ $cvData['layout_preferences']['primary_color'] ?? '#000' }}; 
            font-size: 16pt; 
            padding-bottom: 5px; 
            margin: 20px 0 15px 0;
            text-transform: uppercase;
        }
        h3 { margin: 0 0 5px 0; font-size: 12pt; }
        p { margin: 0; font-size: 11pt; line-height: 1.5; color: #333; }
        ul { margin: 0 0 15px 0; padding-left: 20px; font-size: 11pt; }
        li { margin-bottom: 5px; }

        @media print {
            body { background: #fff; margin: 0; padding: 0; display: block; }
            .a4-paper { width: 100%; height: auto; min-height: auto; margin: 0; padding: 15mm; box-shadow: none; }
        }
    </style>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>
<body>
    <div class="a4-paper">
        <div class="a4-header">
            <h1>{{ $cvData['personal_info']['full_name'] ?? 'Your Name' }}</h1>
            <h3 style="color: {{ $cvData['layout_preferences']['primary_color'] ?? '#555' }}; font-size: 14pt;">{{ $cvData['personal_info']['title'] ?? 'Job Title' }}</h3>
            <p>
                <?php 
                $contacts = [];
                if(!empty($cvData['personal_info']['email'])) $contacts[] = $cvData['personal_info']['email'];
                if(!empty($cvData['personal_info']['phone'])) $contacts[] = $cvData['personal_info']['phone'];
                if(!empty($cvData['personal_info']['links'])) {
                    foreach($cvData['personal_info']['links'] as $link) {
                        if(!empty($link['value'])) $contacts[] = $link['value'];
                    }
                }
                echo implode(' | ', array_map('htmlspecialchars', $contacts));
                ?>
            </p>
        </div>
        
        <div id="cv-sections-container">
            @php $order = $cvData['layout_preferences']['section_order'] ?? ['summary', 'skills', 'experience', 'education', 'certifications']; @endphp
            @foreach($order as $sec)
                <div class="cv-section">
                    <h2>{{ ucfirst($sec) }}</h2>
                    
                    @if($sec === 'summary')
                        <p>{!! nl2br(e($cvData['summary'] ?? '')) !!}</p>
                        
                    @elseif($sec === 'skills')
                        <ul>
                            @foreach($cvData['skills'] ?? [] as $skill)
                                @if(!empty($skill['category']) || !empty($skill['keywords']))
                                    <li><strong>{{ $skill['category'] }}:</strong> {{ implode(', ', $skill['keywords'] ?? []) }}</li>
                                @endif
                            @endforeach
                        </ul>
                        
                    @elseif($sec === 'experience')
                        @foreach($cvData['experience'] ?? [] as $exp)
                            @if(!empty($exp['job_title']) || !empty($exp['company']))
                                <div style="margin-bottom: 15px;">
                                    <h3>{{ $exp['job_title'] }} at {{ $exp['company'] }}</h3>
                                    <p style="font-style: italic; color: #555;">{{ $exp['location'] ?? '' }} | {{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? '' }}</p>
                                    @if(!empty($exp['achievements']) && count($exp['achievements']) > 0)
                                        <ul style="margin-top: 5px;">
                                            @foreach($exp['achievements'] as $ach)
                                                <li>{{ $ach }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        
                    @elseif($sec === 'education')
                        @foreach($cvData['education'] ?? [] as $edu)
                            @if(!empty($edu['institution']) || !empty($edu['degree']))
                                <div style="margin-bottom: 10px;">
                                    <h3>{{ $edu['degree'] }}</h3>
                                    <p>{{ $edu['institution'] }} | Graduated: {{ $edu['graduation_year'] ?? '' }}</p>
                                </div>
                            @endif
                        @endforeach
                        
                    @elseif($sec === 'certifications')
                        <ul>
                            @foreach($cvData['certifications'] ?? [] as $cert)
                                @if(!empty($cert['name']))
                                    <li><strong>{{ $cert['name'] }}</strong> - {{ $cert['issuer'] ?? '' }} ({{ $cert['date'] ?? '' }})</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
