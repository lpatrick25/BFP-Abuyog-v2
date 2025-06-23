<?php
return [
    0 => [ // Occupancy
        'endorsement_from_office_of_the_building_official_obo',
        'certificate_of_completion',
        'certified_true_copy_of_assessment_fee_for_certificate_occupancy_from_obo',
        'as_built_plan_if_necessary',
        'fire_safety_compliance_and_commissioning_report_fsccr_if_necessary',
    ],
    1 => [ // New Business
        'certified_true_copy_of_valid_certificate_of_occupancy',
        'assessment_of_business_permit_fee_tax_assessment_bill_from_bplo', // 🔥 Fixed slash issue
        'affidavit_of_undertaking_no_substantial_changes',
        'copy_of_fire_insurance_if_necessary',
    ],
    2 => [ // Renewal Business
        'assessment_of_the_business_permit_fee_tax_assessment_bill_from_bplo', // 🔥 Fixed slash issue
        'copy_of_fire_insurance_if_necessary',
        'fire_safety_maintenance_report_fsmr_if_necessary',
        'fire_safety_clearance_hot_work_operations_if_required',
    ],
];
