<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Eligibility</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            background-color: #f0f0f0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .certificate {
            width: 100%;
            max-width: 600px;
            background-color: #e8e8e8;
            border: 3px solid #000;
            padding: 40px;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .stamp {
            font-size: 11px;
            text-align: right;
        }

        .stamp-circle {
            width: 50px;
            height: 50px;
            background-color: #4169e1;
            border-radius: 50%;
            margin-left: auto;
            margin-bottom: 5px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .content {
            line-height: 1.8;
            font-size: 14px;
        }

        .field {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 200px;
            padding: 0 10px;
            font-weight: bold;
        }

        .field-short {
            min-width: 80px;
        }

        .field-full {
            flex: 1;
        }

        .row {
            margin-bottom: 15px;
        }

        .row-flex {
            display: flex;
            align-items: baseline;
            gap: 5px;
        }

        .table-row {
            border-bottom: 1px solid #000;
            padding: 8px 0;
            display: flex;
            justify-content: space-between;
        }

        .highlight {
            background-color: transparent;
            font-weight: bold;
        }

        .amount {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .signature-block {
            text-align: center;
            width: 45%;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            padding: 20px 0 5px 0;
            font-weight: bold;
        }

        .signature-label {
            font-size: 11px;
        }

        .approval-section {
            text-align: center;
            margin-top: 30px;
        }

        .approval-title {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .approver {
            font-weight: bold;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .approver-title {
            font-size: 12px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <div></div>
            <div class="stamp">
                <div class="stamp-circle"></div>
                <div>4Ps -</div>
                <div>Non 4Ps</div>
            </div>
        </div>

        <h1>CERTIFICATE OF ELIGIBILITY</h1>

        <div class="content">
            <div class="row-flex">
                <span>This is to Certify</span>
                <span class="field field-full">JOHN D. CANETE JR</span>
                <span>age:</span>
                <span class="field field-short">32y.o</span>
            </div>

            <div class="row-flex">
                <span>Residing at</span>
                <span class="field field-full">Brgy. Barangay 6, Kabankalan</span>
            </div>

            <div class="row">
                with following member/s:
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="table-row" style="font-weight: bold;">
                    <span>Father/1 children</span>
                </div>
                <div class="table-row">
                    <span>Aiyana D. Canete</span>
                    <span>7yrs old/Daughter</span>
                    <span>Herein case</span>
                </div>
                <div class="table-row">
                    <span></span>
                </div>
                <div class="table-row">
                    <span></span>
                </div>
            </div>

            <div class="row" style="margin-top: 25px;">
                has been found eligible for cash assistance under <span class="field" style="text-align: right;">AICS</span>
            </div>

            <div class="row" style="text-align: right; font-size: 12px;">
                (Specify)
            </div>

            <div class="row-flex" style="margin-top: 25px;">
                <span>in the amount of</span>
                <span class="field field-full" style="text-align: center;">PHP 5,000.00 HGFD</span>
            </div>

            <div class="row-flex">
                <span>records of the case dated</span>
                <span class="field field-full" style="text-align: center;">November 18, 2025</span>
                <span>are in the</span>
            </div>

            <div class="row">
                file of CSWD Office, Kabankalan City unit office.
            </div>
        </div>

        <div class="signatures">
            <div class="signature-block">
                <div class="signature-line">JOHN D. CANETE JR</div>
                <div class="signature-label">Signature or thumb mark of client</div>
            </div>
            <div class="signature-block">
                <div class="signature-line">JEAN PALMARES RSW</div>
                <div class="signature-label">Social Welfare Officer II</div>
            </div>
        </div>

        <div class="approval-section">
            <div class="approval-title">RECOMMENDING APPROVAL:</div>
            <div class="approver">CYRIL D. RAMOS, RSW, MSSW</div>
            <div class="approver-title">City Social Welfare and Development Officer</div>

            <div class="approval-title" style="margin-top: 20px;">APPROVED:</div>
            <div class="approver">BENJIE M. MIRANDA</div>
            <div class="approver-title">City Mayor</div>
        </div>
    </div>
</body>
</html>