<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MentorshipForm;
use App\Models\MentorshipFormField;

class MentorshipFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Form 1: Mentorship Agreement
        $form1 = MentorshipForm::create([
            'form_type' => 'mentorship_agreement',
            'title' => 'Mentorship Agreement',
            'description' => 'This agreement outlines the expectations, goals, and commitments for both the mentor and mentee.',
            'order' => 1,
            'phase' => 'first_meeting',
            'completion_by' => 'both',
            'requires_signature' => true,
            'active' => true,
        ]);

        // Form 1 Fields
        $this->createFormFields($form1, [
            [
                'field_type' => 'text',
                'label' => 'Mentor Name',
                'description' => 'Full name of the mentor',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'text',
                'label' => 'Mentee Name',
                'description' => 'Full name of the mentee',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'date',
                'label' => 'Start Date',
                'description' => 'When does this mentorship relationship begin?',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'date',
                'label' => 'End Date (Optional)',
                'description' => 'When will this mentorship relationship end? (Leave blank if ongoing)',
                'required' => false,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Mentorship Goals',
                'description' => 'What are the primary goals of this mentorship relationship?',
                'required' => true,
                'order' => 5,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Meeting Frequency',
                'description' => 'How often will mentor and mentee meet? (e.g., weekly, bi-weekly)',
                'required' => true,
                'order' => 6,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Mentor Responsibilities',
                'description' => 'What are the responsibilities of the mentor in this relationship?',
                'required' => true,
                'order' => 7,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Mentee Responsibilities',
                'description' => 'What are the responsibilities of the mentee in this relationship?',
                'required' => true,
                'order' => 8,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Confidentiality Agreement',
                'description' => 'Both parties agree to keep discussions confidential unless otherwise agreed upon.',
                'required' => true,
                'order' => 9,
            ],
            [
                'field_type' => 'checkbox',
                'label' => 'Mentor Signature',
                'description' => 'I agree to the terms of this mentorship agreement.',
                'required' => true,
                'order' => 10,
            ],
            [
                'field_type' => 'checkbox',
                'label' => 'Mentee Signature',
                'description' => 'I agree to the terms of this mentorship agreement.',
                'required' => true,
                'order' => 11,
            ],
        ]);

        // First Meeting (Mentor Reflection)
        $firstMeetingMentor = MentorshipForm::create([
            'form_type' => 'first_meeting_mentor',
            'title' => 'First Meeting (Mentor Reflection)',
            'description' => 'Mentor: Reflect on your first meeting with your mentee.',
            'order' => 1,
            'phase' => 'first_meeting',
            'completion_by' => 'mentor',
            'requires_signature' => false,
            'active' => true,
        ]);
        $this->createFormFields($firstMeetingMentor, [
            [
                'field_type' => 'textarea',
                'label' => 'What were your first impressions of your mentee?',
                'description' => '',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'What goals did you discuss?',
                'description' => '',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'What are your next steps as a mentor?',
                'description' => '',
                'required' => true,
                'order' => 3,
            ],
        ]);

        // First Meeting (Mentee Reflection)
        $firstMeetingMentee = MentorshipForm::create([
            'form_type' => 'first_meeting_mentee',
            'title' => 'First Meeting (Mentee Reflection)',
            'description' => 'Mentee: Reflect on your first meeting with your mentor.',
            'order' => 2,
            'phase' => 'first_meeting',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);
        $this->createFormFields($firstMeetingMentee, [
            [
                'field_type' => 'textarea',
                'label' => 'What were your first impressions of your mentor?',
                'description' => '',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'What goals did you discuss?',
                'description' => '',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'What are your next steps as a mentee?',
                'description' => '',
                'required' => true,
                'order' => 3,
            ],
        ]);

        // Form 2: Success Description
        $form2 = MentorshipForm::create([
            'form_type' => 'success_description',
            'title' => 'Success Description',
            'description' => 'Define what success looks like for the mentee\'s business.',
            'order' => 2,
            'phase' => 'first_meeting',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 2 Fields
        $this->createFormFields($form2, [
            [
                'field_type' => 'textarea',
                'label' => 'Business Vision',
                'description' => 'Describe your vision for your business in 1-2 years',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Key Success Metrics',
                'description' => 'What metrics will indicate success for your business? (e.g., revenue, customers, market share)',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Personal Definition of Success',
                'description' => 'How do you personally define success for yourself as an entrepreneur?',
                'required' => true,
                'order' => 3,
            ],
        ]);

        // Form 3: Growth Area Identification
        $form3 = MentorshipForm::create([
            'form_type' => 'growth_area_identification',
            'title' => 'Growth Area Identification',
            'description' => 'Identify key areas for growth and improvement.',
            'order' => 3,
            'phase' => 'first_meeting',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 3 Fields
        $this->createFormFields($form3, [
            [
                'field_type' => 'textarea',
                'label' => 'Current Business Strengths',
                'description' => 'List 3-5 strengths of your current business',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Current Business Weaknesses',
                'description' => 'List 3-5 areas where your business needs improvement',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Personal Development Areas',
                'description' => 'What skills or knowledge do you need to develop as a business leader?',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Priority Growth Areas',
                'description' => 'Which 1-3 areas should be prioritized for immediate focus?',
                'required' => true,
                'order' => 4,
            ],
        ]);

        // Form 4: Core Values Determination
        $form4 = MentorshipForm::create([
            'form_type' => 'core_values_determination',
            'title' => 'Core Values Determination',
            'description' => 'Define the core values that guide your business decisions.',
            'order' => 4,
            'phase' => 'first_meeting',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 4 Fields
        $this->createFormFields($form4, [
            [
                'field_type' => 'textarea',
                'label' => 'Core Value 1',
                'description' => 'Describe one core value of your business and why it matters',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Core Value 2',
                'description' => 'Describe another core value of your business and why it matters',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Core Value 3',
                'description' => 'Describe another core value of your business and why it matters',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Additional Core Values (Optional)',
                'description' => 'Describe any additional core values of your business',
                'required' => false,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Values in Action',
                'description' => 'How will these values guide your business decisions and operations?',
                'required' => true,
                'order' => 5,
            ],
        ]);

        // Form 5: Five Year Vision Determination
        $form5 = MentorshipForm::create([
            'form_type' => 'five_year_vision',
            'title' => 'Five Year Vision Determination',
            'description' => 'Define your long-term vision for your business.',
            'order' => 5,
            'phase' => 'first_meeting',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 5 Fields
        $this->createFormFields($form5, [
            [
                'field_type' => 'textarea',
                'label' => 'Five-Year Business Vision',
                'description' => 'Describe where you see your business in five years',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Market Position',
                'description' => 'What market position do you aim to achieve in five years?',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Team Growth',
                'description' => 'How do you envision your team growing over five years?',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Financial Goals',
                'description' => 'What are your financial targets for five years from now?',
                'required' => true,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Impact Goals',
                'description' => 'What impact do you want your business to have made in five years?',
                'required' => true,
                'order' => 5,
            ],
        ]);

        // Form 6: Competitive Advantage in Market
        $form6 = MentorshipForm::create([
            'form_type' => 'competitive_advantage',
            'title' => 'Competitive Advantage in Market',
            'description' => 'Identify your unique competitive advantages in the marketplace.',
            'order' => 6,
            'phase' => 'first_meeting',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 6 Fields
        $this->createFormFields($form6, [
            [
                'field_type' => 'textarea',
                'label' => 'Key Competitors',
                'description' => 'List your main competitors in the market',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Unique Value Proposition',
                'description' => 'What makes your business unique compared to competitors?',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Sustainable Advantages',
                'description' => 'Which of your advantages are sustainable over time?',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Market Positioning',
                'description' => 'How do you position your business in the market?',
                'required' => true,
                'order' => 4,
            ],
        ]);

        // Form 7: Company Current Situation Assessment
        $form7 = MentorshipForm::create([
            'form_type' => 'company_assessment',
            'title' => 'Company Current Situation Assessment',
            'description' => 'Comprehensive assessment of your company\'s current situation.',
            'order' => 7,
            'phase' => 'ongoing_meetings',
            'completion_by' => 'mentee',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 7 Fields
        $this->createFormFields($form7, [
            [
                'field_type' => 'textarea',
                'label' => 'Decision Making Process',
                'description' => 'Describe how decisions are currently made in your company',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Management Structure',
                'description' => 'Describe your current management structure and effectiveness',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Product/Service Assessment',
                'description' => 'Evaluate your current products or services and their market fit',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Marketing Effectiveness',
                'description' => 'Assess your current marketing strategies and results',
                'required' => true,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Operational Efficiency',
                'description' => 'Evaluate your operational processes and efficiency',
                'required' => true,
                'order' => 5,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Financial Health',
                'description' => 'Assess your company\'s current financial situation',
                'required' => true,
                'order' => 6,
            ],
        ]);

        // Form 8: Meeting Notes
        $form8 = MentorshipForm::create([
            'form_type' => 'meeting_notes',
            'title' => 'Meeting Notes',
            'description' => 'Document discussions and action items from mentorship meetings.',
            'order' => 8,
            'phase' => 'ongoing_meetings',
            'completion_by' => 'mentor',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 8 Fields
        $this->createFormFields($form8, [
            [
                'field_type' => 'date',
                'label' => 'Meeting Date',
                'description' => 'Date of the mentorship meeting',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'text',
                'label' => 'Meeting Duration',
                'description' => 'How long was the meeting (e.g., 1 hour)',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Topics Discussed',
                'description' => 'Summary of the main topics discussed during the meeting',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Key Insights',
                'description' => 'Important insights or realizations from the discussion',
                'required' => true,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Action Items for Mentor',
                'description' => 'Tasks or actions the mentor will take before the next meeting',
                'required' => false,
                'order' => 5,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Action Items for Mentee',
                'description' => 'Tasks or actions the mentee will take before the next meeting',
                'required' => true,
                'order' => 6,
            ],
            [
                'field_type' => 'date',
                'label' => 'Next Meeting Date',
                'description' => 'Planned date for the next mentorship meeting',
                'required' => false,
                'order' => 7,
            ],
        ]);

        // Form 9: Homework Tracking
        $form9 = MentorshipForm::create([
            'form_type' => 'homework_tracking',
            'title' => 'Homework Tracking Form',
            'description' => 'Track progress on assigned tasks between mentorship meetings.',
            'order' => 9,
            'phase' => 'ongoing_meetings',
            'completion_by' => 'both',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 9 Fields
        $this->createFormFields($form9, [
            [
                'field_type' => 'textarea',
                'label' => 'Assigned Tasks',
                'description' => 'List of tasks assigned during the previous meeting',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Completed Tasks',
                'description' => 'Tasks that have been completed since the last meeting',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'In-Progress Tasks',
                'description' => 'Tasks that are still in progress',
                'required' => false,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Challenges Encountered',
                'description' => 'Any challenges or obstacles faced while working on tasks',
                'required' => false,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Mentor Comments',
                'description' => 'Feedback from the mentor on task progress',
                'required' => false,
                'order' => 5,
            ],
        ]);

        // Add mentor review fields to forms that require mentor review/signature
        $formsNeedingMentorReview = [$form9];
        foreach ($formsNeedingMentorReview as $form) {
            $order = MentorshipFormField::where('mentorship_form_id', $form->id)->max('order') + 1;
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'textarea',
                'label' => 'Mentor Comments',
                'description' => 'Mentor review/comments on this submission',
                'required' => false,
                'order' => $order,
            ]);
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'checkbox',
                'label' => 'Mentor Signature',
                'description' => 'Mentor signature/approval for this form',
                'required' => true,
                'order' => $order + 1,
            ]);
        }

        // Form 10: Action Plan
        $form10 = MentorshipForm::create([
            'form_type' => 'action_plan',
            'title' => 'Action Plan',
            'description' => 'Detailed plan for achieving specific business goals.',
            'order' => 10,
            'phase' => 'ongoing_meetings',
            'completion_by' => 'both',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 10 Fields
        $this->createFormFields($form10, [
            [
                'field_type' => 'textarea',
                'label' => 'Goal Statement',
                'description' => 'Clear statement of the goal to be achieved',
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Action Steps',
                'description' => 'Specific steps needed to achieve the goal',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Resources Needed',
                'description' => 'Resources, tools, or support required',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Timeline',
                'description' => 'Timeline for completing each action step',
                'required' => true,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Success Metrics',
                'description' => 'How will success be measured?',
                'required' => true,
                'order' => 5,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Potential Obstacles',
                'description' => 'Potential challenges and how they will be addressed',
                'required' => true,
                'order' => 6,
            ],
        ]);

        // Add mentor review fields to forms that require mentor review/signature
        $formsNeedingMentorReview = [$form10];
        foreach ($formsNeedingMentorReview as $form) {
            $order = MentorshipFormField::where('mentorship_form_id', $form->id)->max('order') + 1;
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'textarea',
                'label' => 'Mentor Comments',
                'description' => 'Mentor review/comments on this submission',
                'required' => false,
                'order' => $order,
            ]);
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'checkbox',
                'label' => 'Mentor Signature',
                'description' => 'Mentor signature/approval for this form',
                'required' => true,
                'order' => $order + 1,
            ]);
        }

        // Form 11: Mentor/Mentee Feedback
        $form11 = MentorshipForm::create([
            'form_type' => 'mentorship_feedback',
            'title' => 'Mentor/Mentee Feedback Form',
            'description' => 'Provide feedback on the mentorship relationship and progress.',
            'order' => 11,
            'phase' => 'feedback_resources',
            'completion_by' => 'both',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 11 Fields
        $this->createFormFields($form11, [
            [
                'field_type' => 'select',
                'label' => 'Overall Satisfaction',
                'description' => 'How satisfied are you with the mentorship relationship?',
                'options' => ['Very Dissatisfied', 'Dissatisfied', 'Neutral', 'Satisfied', 'Very Satisfied'],
                'required' => true,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'What\'s Working Well',
                'description' => 'Aspects of the mentorship that are working well',
                'required' => true,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Areas for Improvement',
                'description' => 'Aspects of the mentorship that could be improved',
                'required' => true,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Progress Toward Goals',
                'description' => 'Assessment of progress toward mentorship goals',
                'required' => true,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Additional Comments',
                'description' => 'Any other feedback or comments',
                'required' => false,
                'order' => 5,
            ],
        ]);

        // Add mentor review fields to forms that require mentor review/signature
        $formsNeedingMentorReview = [$form11];
        foreach ($formsNeedingMentorReview as $form) {
            $order = MentorshipFormField::where('mentorship_form_id', $form->id)->max('order') + 1;
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'textarea',
                'label' => 'Mentor Comments',
                'description' => 'Mentor review/comments on this submission',
                'required' => false,
                'order' => $order,
            ]);
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'checkbox',
                'label' => 'Mentor Signature',
                'description' => 'Mentor signature/approval for this form',
                'required' => true,
                'order' => $order + 1,
            ]);
        }

        // Form 12: Suggested Resources
        $form12 = MentorshipForm::create([
            'form_type' => 'suggested_resources',
            'title' => 'Suggested Readings/Videos/Other Resources',
            'description' => 'Share helpful resources for continued learning and development.',
            'order' => 12,
            'phase' => 'feedback_resources',
            'completion_by' => 'mentor',
            'requires_signature' => false,
            'active' => true,
        ]);

        // Form 12 Fields
        $this->createFormFields($form12, [
            [
                'field_type' => 'textarea',
                'label' => 'Books',
                'description' => 'Recommended books related to the mentee\'s business or growth areas',
                'required' => false,
                'order' => 1,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Articles',
                'description' => 'Relevant articles or blog posts',
                'required' => false,
                'order' => 2,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Videos',
                'description' => 'Helpful videos, talks, or presentations',
                'required' => false,
                'order' => 3,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Courses',
                'description' => 'Courses or training programs that might be beneficial',
                'required' => false,
                'order' => 4,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Tools',
                'description' => 'Useful tools or software for the mentee\'s business',
                'required' => false,
                'order' => 5,
            ],
            [
                'field_type' => 'textarea',
                'label' => 'Networks',
                'description' => 'Relevant professional networks or communities',
                'required' => false,
                'order' => 6,
            ],
        ]);

        // Add mentor review fields to forms that require mentor review/signature
        $formsNeedingMentorReview = [];
        foreach (['form1','form2','form3','form4','form5','form6','form7','form9','form10','form11'] as $var) {
            if (isset($$var)) $formsNeedingMentorReview[] = $$var;
        }
        foreach ($formsNeedingMentorReview as $form) {
            $order = MentorshipFormField::where('mentorship_form_id', $form->id)->max('order') + 1;
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'textarea',
                'label' => 'Mentor Comments',
                'description' => 'Mentor review/comments on this submission',
                'required' => false,
                'order' => $order,
            ]);
            MentorshipFormField::create([
                'mentorship_form_id' => $form->id,
                'field_type' => 'checkbox',
                'label' => 'Mentor Signature',
                'description' => 'Mentor signature/approval for this form',
                'required' => true,
                'order' => $order + 1,
            ]);
        }
    }

    /**
     * Helper method to create form fields.
     *
     * @param MentorshipForm $form
     * @param array $fields
     * @return void
     */
    private function createFormFields(MentorshipForm $form, array $fields): void
    {
        foreach ($fields as $field) {
            MentorshipFormField::create(array_merge(
                ['mentorship_form_id' => $form->id],
                $field
            ));
        }
    }
}