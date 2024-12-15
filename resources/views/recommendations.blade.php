@props(['record'])

@php
    function generateReport($fields)
    {


        $emptyFields = [];
        $recommendations = [];

        // Check each field and add corresponding report and recommendation
        if (empty($fields['dosage'])) {
            $emptyFields[] = "Dossing";
            $recommendations[] = "Provide the dossing details to communicate accurate usage instructions.";
        }
        if (empty($fields['active_ingredient'])) {
            $emptyFields[] = "Active Ingredient";
            $recommendations[] = "Specify the active ingredient for proper classification and identification.";
        }
        if (empty($fields['indication'])) {
            $emptyFields[] = "Indication";
            $recommendations[] = "Fill in the indication to clarify the product's purpose.";
        }
        if (empty($fields['expiry_date'])) {
            $emptyFields[] = "Date of Expiry";
            $recommendations[] = "Enter the date of expiry to comply with safety and regulatory guidelines.";
        }

        $rep = [
            'emptyFields' => $emptyFields,
            'recommendations' => $recommendations
        ];

        return $rep;
    }

    $report = generateReport($record)
@endphp

<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    <div>

        <!-- <h1 class="text-2xl font-bold mb-4 text-gray-800">Report</h1> -->

        <div class="mb-6">
            @if (!empty($report['emptyFields']))
                <p class="text-lg font-semibold mb-2 text-gray-700">The following fields were left blank:</p>
                <ul class="list-disc list-inside text-gray-600">
                    @foreach ($report['emptyFields'] as $field)
                        <li><strong>{{ $field }}</strong></li>
                    @endforeach
                </ul>
            @else
                <p>All fields are filled in.</p>
            @endif
        </div>

        <div>
            @if (!empty($report['recommendations']))
                <p class="text-lg font-semibold mb-2 text-gray-700"><strong>Recommendations:</strong></p>
                <ul class="list-disc list-inside text-gray-600">
                    @foreach ($report['recommendations'] as $recommendation)
                        <li>{{ $recommendation }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</div>