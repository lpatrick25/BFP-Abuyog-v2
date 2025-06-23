<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Safety Inspection Certificate</title>
    <style type="text/css" media="print">
        @page {
            size: Legal portrait;
            margin: 0;
        }
    </style>
    <style rel="stylesheet" type="text/css" media="all">
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            line-height: 1.5;
            padding: 20px;
            width: 816px;
            /* 8.5 inches */
            height: 1344px;
            /* 14 inches */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }

        .certificate {
            border: 2px solid black;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin: 20px;
        }

        .sub-header {
            text-align: center;
            font-size: 14px;
            margin-top: -10px;
        }

        .section {
            margin: 20px 0;
        }

        .bold {
            font-weight: bold;
        }

        .note {
            font-size: 13px;
            margin-top: 50px;
            font-weight: bold;
            text-align: center;
            padding: 0 20px;
            font-style: italic;
        }

        .footer {
            margin-top: -1px;
            text-align: center;
            padding: 0 20px;
            font-weight: bold;
        }

        .centered {
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin: 10px;
        }

        .left {
            flex: 1;
        }

        .right {
            flex: 1;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="header">
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="width: 20%; text-align: center;">
                        <img src="{{ asset('img/dilg.webp') }}" alt="DILG Logo" style="height: 120px; width: 120px;">
                    </td>
                    <td style="width: 60%; text-align: center;">
                        <p>Republic of the Philippines</p>
                        <p style="margin-top: -5px; font-weight: bolder;">Department of the Interior and Local
                            Government</p>
                        <p style="margin-top: -5px; color: blue; font-weight: bolder;">Bureau of Fire Protection</p>
                        <p style="margin-top: -5px;">Region 8</p>
                        <p style="margin-top: -5px;">Abuyog Fire Department</p>
                        <p style="margin-top: -5px;">Brgy. Loyonsawang, Abuyog, Leyte</p>
                    </td>
                    <td style="width: 20%; text-align: center;">
                        <img src="{{ asset('img/bfp.webp') }}" alt="BFP Logo" style="height: 120px; width: 120px;">
                    </td>
                </tr>
            </table>
            <table style="width: 100%; margin-top: -20px;">
                <tr>
                    <td style="text-align: center;">
                        <p style="margin-top: -5px;">Cellphone No. 0916-908-5788 | abuyogfsnorthleyte@gmail.com</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="container">
            <table style="width: 100%; margin-bottom: 20px; margin-left: 10px; margin-right: 10px;">
                <tr>
                    <td style="width: 50%; text-align: center; vertical-align: top;">
                        <span class="bold" style="color: red;">FSIC NO.:</span>
                        <span style="border-bottom: 3px solid red;">{{ $fsic->fsic_no }}</span>
                    </td>
                    <td style="width: 50%; text-align: center; vertical-align: top;">
                        <p style="display: inline-block; border-bottom: 1px solid black; padding: 0 15px;">
                            {{ date('F j, Y', strtotime($fsic->issue_date)) }}
                        </p>
                        <p>Date</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="header" style="font-weight: bolder; margin-top: -25px; color: blue;">
            <h2>FIRE SAFETY INSPECTION CERTIFICATE</h2>
        </div>

        <div class="section" style="text-align: center; margin-top: -25px;">
            <table style="margin: auto;">
                <tr>
                    <td style="padding-right: 10px;">
                        <input type="checkbox" @if ($fsic->application->fsic_type == 0) checked @endif>
                    </td>
                    <td style="text-align: left; color: blue;">
                        FOR CERTIFICATE OF OCCUPANCY
                    </td>
                </tr>
                <tr>
                    <td style="padding-right: 10px;">
                        <input type="checkbox" @if ($fsic->application->fsic_type == 1 || $fsic->application->fsic_type == 2) checked @endif>
                    </td>
                    <td style="text-align: left; color: blue;">
                        FOR BUSINESS PERMIT (NEW/RENEWAL)
                    </td>
                </tr>
                <tr>
                    <td style="padding-right: 10px;">
                        <input type="checkbox" @if ($fsic->application->fsic_type < 0) checked @endif>
                    </td>
                    <td style="text-align: left; color: blue;">
                        OTHERS
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p style="margin-top: -5px;"><b>TO WHOM IT MAY CONCERN:</b></p>
            <p style="text-indent: 45px; text-align: justify; margin-top: 10px;">
                By virtue of the provisions of RA 9514 otherwise known as the Fire Code of the Philippines of 2008, the
                application for
                <span class="bold">FIRE SAFETY INSPECTION CERTIFICATE</span> of&nbsp;
                <span style="display: inline-block; width: 100%;"></span>
            </p>
            <p style="width: 100%; text-align: center; border-bottom: 1px solid black; margin-top: -25px;">
                {{ $fsic->application->establishment->name }}
            </p>
            <p style="width: 100%; text-align: center; margin: 0; padding: 0;">
                (Name of Establishment)
            </p>
            <p style="text-align: justify; margin-top: -1px; margin-bottom: -25px;">
                owned and managed by <span class="bold"
                    style="border-bottom: 1px solid black; padding: 0 50px;">{{ $fsic->application->establishment->client->getFullName() }}</span>
                with
                postal address
                at &nbsp;
                <span style="display: inline-block; width: 100%;"></span>
            </p>
            <p style="width: 100%; text-align: center; margin: 0; padding: 0;">
                (Name of Owner/Representative)
            </p>
            <p style="text-align: center; border-bottom: 1px solid black;">
                {{ ucwords(strtolower($fsic->application->establishment->address_brgy)) }}, Abuyog, Leyte
            </p>
            <p style="width: 100%; text-align: center; margin: 0; padding: 0;">
                (Address)
            </p>
            <p style="text-align: justify;">
                is hereby GRANTED after said building structure or facility has been duly inspected with the finding
                that it has fully complied with the fire safety and protection requirements of the Fire Code of the
                Philippines of 2008 and its Revised Implementing Rules and Regulations.
            </p>
            <p style="text-indent: 45px; text-align: justify;; margin-top: 10px;">
                This certification is valid for
                <span class="bold" style="border-bottom: 1px solid black; padding: 0 50px;">@if ($fsic->application->fsic_type != 0) Business Permit @else Certificate of Occupancy @endif</span>
                valid until
                <span class="bold"
                    style="border-bottom: 1px solid black; padding: 0 50px;">{{ date('F j, Y', strtotime($fsic->expiration_date)) }}</span>
            </p>
            <p style="text-indent: 45px; text-align: justify;; margin-top: 30px;">
                Violation of Fire Code provisions shall cause this certificate <span class="bold">null and void</span>
                after appropriate proceeding and shall hold the owner liable to the penalties provided for by the said
                Fire Code.
            </p>
        </div>
        <table style="width: 100%; margin: 30px 50px; border-spacing: 0;">
            <tr>
                <!-- Left Column: Fire Code Fees -->
                <td style="width: 50%; text-align: left; vertical-align: top;">
                    <p><b>Fire Code Fees:</b></p>
                    <p>Amount Paid: <b>{{ $fsic->amount }}</b></p>
                    <p>O.R. Number: <b>{{ $fsic->or_number }}</b></p>
                    <p>Date: <b>{{ date('F j, Y', strtotime($fsic->payment_date)) }}</b></p>
                    <img src="{{ $fsic->fsicQrCode }}" alt="QR Code" style="height: 130px; width: 130px;">
                </td>

                <!-- Right Column: Approval Section -->
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: left;"><b>RECOMMEND APPROVAL:</b></p>
                    <p style="text-align: center; border-bottom: 1px solid black; margin: 0; width: 80%;">
                        {{ $fsic->inspector->getFullName() }}</p>
                    <p style="text-align: center; margin: 0; width: 80%;">CHIEF, Fire Safety Enforcement Section</p>
                    <p style="text-align: left; margin-top: 30px;"><b>APPROVED:</b></p>
                    <p style="text-align: center; border-bottom: 1px solid black; margin: 0; width: 80%;">
                        {{ $fsic->marshall->getFullName() }}</p>
                    <p style="text-align: center; margin: 0; width: 80%;">CITY/MUNICIPAL FIRE MARSHAL</p>
                </td>
            </tr>
        </table>

        <div class="note">
            <p>NOTE: "This Certificate does not take the place of any license required by law and is not transferable.
                Any change in the use of occupancy of the premises shall require a new certificate."</p>
        </div>

        <div class="footer">
            <p style="font-size: 15px;">THIS CERTIFICATE SHALL BE POSTED CONSPICUOUSLY</p>
            <p style="font-size: 13px; color: red;"> PAALALA: "MAHIGPIT NA IPINAGBABAWAL NG PAMUNUAN NG BUREAU OF FIRE
                PROTECTION SA MGA KAWANI NITO ANG
                MAGBENTA O MAGREKOMENDA NG ANUMANG BRAND NG FIRE EXTINGUISHER"</p>
            <p style="font-size: 15px;">"FIRE SAFETY IS OUR MAIN CONCERN"</p>
        </div>
    </div>
</body>

</html>
