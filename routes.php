<?php

return [
    '/' => 'User@index',
    '/about' => 'User@about',
    '/login' => 'User@login',
    '/logout' => 'User@logout',
    '/register' => 'User@register',
    '/partnership' => 'User@partnership',
    '/news' => 'User@news',
    '/events' => 'User@events',
    '/pool_of_experts' => 'User@pool_of_experts',
    '/inquiry' => 'User@inquiry',

    '/news/{content_id}' => 'User@news_content',
    '/event/{content_id}' => 'User@event_content',

    '/reset_password' => 'User@reset_password',
    '/reset' => 'User@reset',
    '/resetPass' => 'User@resetPass',

    /* Student Routes */
    '/student/index' => 'Student@index',
    '/student/dashboard' => 'Student@dashboard',
    '/student/inquiry' => 'Student@inquiry',
    
    '/student/profile' => 'Student@profile',
    '/student/profile/update' => 'Student@updateProfile',

    '/student/linkage_and_partners' => 'Student@linkage_and_partners',
    '/student/linkage_and_partners/getAll' => 'Student@getLinkageAndPartners',

    '/student/institutional_membership' => 'Student@institutional_membership',
    '/student/institutional_membership/getAll' => 'Student@getInstitutionalMemberships',

    '/student/ojt_partners' => 'Student@ojt_partners',
    '/student/ojt_partners/getAll' => 'Student@getOJTPartners',

    /* Partner Routes */
    '/partner/index' => 'Partner@index',
    '/partner/dashboard' => 'Partner@dashboard',
    '/partner/inquiry' => 'Partner@inquiry',
    
    '/partner/profile' => 'Partner@profile',
    '/partner/profile/update' => 'Partner@updateProfile',

    '/partner/appointments' => 'Partner@appointments',
    '/partner/appointments/getAll' => 'Partner@getAllAppointments',
    '/partner/appointments/create' => 'Partner@createAppointment',
    '/partner/appointments/update/{appointment_id}' => 'Partner@updateAppointment',
    '/partner/appointments/delete/{appointment_id}' => 'Partner@deleteAppointment',

    '/partner/linkage_and_partners' => 'Partner@linkage_and_partners',
    '/partner/linkage_and_partners/getAll' => 'Partner@getLinkageAndPartners',
    '/partner/institutional_membership' => 'Partner@institutional_membership',
    '/partner/institutional_membership/getAll' => 'Partner@getInstitutionalMemberships',
    '/partner/ojt_partners' => 'Partner@ojt_partners',
    '/partner/ojt_partners/getAll' => 'Partner@getOJTPartners',

    '/partner/content/create' => 'Partner@createContent',
    '/partner/content/update/{content_id}' => 'Partner@updateContent',
    '/partner/content/delete/{content_id}' => 'Partner@deleteContent',
    '/partner/content/approve/{content_id}' => 'Partner@approveContent',

    '/partner/announcements' => 'Partner@announcements',
    '/partner/announcements/getAll' => 'Partner@getAnnouncements',

    '/partner/events' => 'Partner@events',
    '/partner/events/getAll' => 'Partner@getEvents',

    '/partner/news' => 'Partner@news',
    '/partner/news/getAll' => 'Partner@getNews',

    '/partner/confidential_document' => 'Partner@confidential_document',
    '/partner/confidential_document/create' => 'Partner@createRequest',
    '/partner/confidential_document/approve/{document_id}' => 'Partner@approveRequest',
    '/partner/confidential_document/deny/{document_id}' => 'Partner@denyRequest',
    '/partner/confidential_document/delete/{document_id}' => 'Partner@deleteRequest',

    '/partner/confidential_document/requests/getAll' => 'Partner@getAllRequests',
    '/partner/confidential_document/files/getAll' => 'Partner@getAllFiles',
    
    /* Admin Routes */
    '/admin/index' => 'Admin@index',
    '/admin/dashboard' => 'Admin@dashboard',
    
    '/admin/students' => 'Admin@students',
    '/admin/students/getAll' => 'Admin@getAllStudents',
    '/admin/students/update/{user_id}' => 'Admin@updateStudent',
    '/admin/students/delete/{user_id}' => 'Admin@deleteStudent',

    '/admin/partners' => 'Admin@partners',
    '/admin/partners/getAll' => 'Admin@getAllPartners',
    '/admin/partners/update/{user_id}' => 'Admin@updatePartner',
    '/admin/partners/delete/{user_id}' => 'Admin@deletePartner',

    '/admin/for_approvals' => 'Admin@for_approvals',
    '/admin/for_approvals/getAll' => 'Admin@getForApprovals',

    '/admin/content/create' => 'Admin@createContent',
    '/admin/content/update/{content_id}' => 'Admin@updateContent',
    '/admin/content/delete/{content_id}' => 'Admin@deleteContent',
    '/admin/content/approve/{content_id}' => 'Admin@approveContent',

    '/admin/announcements' => 'Admin@announcements',
    '/admin/announcements/getAll' => 'Admin@getAnnouncements',

    '/admin/events' => 'Admin@events',
    '/admin/events/getAll' => 'Admin@getEvents',

    '/admin/news' => 'Admin@news',
    '/admin/news/getAll' => 'Admin@getNews',

    '/admin/linkage_and_partners' => 'Admin@linkage_and_partners',
    '/admin/linkage_and_partners/getAll' => 'Admin@getLinkageAndPartners',
    '/admin/linkage_and_partners/create' => 'Admin@createLinkageAndPartners',
    '/admin/linkage_and_partners/update/{linkage_id}' => 'Admin@updateLinkageAndPartners',
    '/admin/linkage_and_partners/delete/{linkage_id}' => 'Admin@deleteLinkageAndPartners',

    '/admin/ojt_partners' => 'Admin@ojt_partners',
    '/admin/ojt_partners/getAll' => 'Admin@getOJTPartners',
    '/admin/ojt_partners/create' => 'Admin@createOJTPartners',
    '/admin/ojt_partners/update/{ojt_id}' => 'Admin@updateOJTPartners',
    '/admin/ojt_partners/delete/{ojt_id}' => 'Admin@deleteOJTPartners',

    '/admin/institutional_membership' => 'Admin@institutional_membership',
    '/admin/institutional_membership/getAll' => 'Admin@getInstitutionalMemberships',
    '/admin/institutional_membership/create' => 'Admin@createInstitutionalMemberships',
    '/admin/institutional_membership/update/{institutional_membership_id}' => 'Admin@updateInstitutionalMemberships',
    '/admin/institutional_membership/delete/{institutional_membership_id}' => 'Admin@deleteInstitutionalMemberships',

    '/admin/pool_of_experts' => 'Admin@pool_of_experts',
    '/admin/pool_of_experts/getAll' => 'Admin@getAllExperts',
    '/admin/pool_of_experts/create' => 'Admin@createExpert',
    '/admin/pool_of_experts/update/{expert_id}' => 'Admin@updateExpert',
    '/admin/pool_of_experts/delete/{expert_id}' => 'Admin@deleteExpert',

    '/admin/appointments' => 'Admin@appointments',
    '/admin/appointments/getAll' => 'Admin@getAllAppointments',
    '/admin/appointments/create' => 'Admin@createAppointment',
    '/admin/appointments/getPartner/{partner_id}' => 'Admin@getPartner',
    '/admin/appointments/update/{appointment_id}' => 'Admin@updateAppointment',
    '/admin/appointments/delete/{appointment_id}' => 'Admin@deleteAppointment',
    '/admin/appointments/change/{appointment_id}' => 'Admin@changeAppointment',

    '/admin/inquiry' => 'Admin@inquiry',
    '/admin/inquiry/getAll' => 'Admin@getAllInquiry',
    '/admin/inquiry1/getAll' => 'Admin@getAllInquiry1',
    '/admin/inquiry/reply' => 'Admin@replyInquiry',
    '/admin/inquiry/delete/{inquiry_id}' => 'Admin@deleteInquiry',
    '/admin/inquiry/delete1/{inquiry_id}' => 'Admin@deleteInquiry1',

    '/admin/confidential_document' => 'Admin@confidential_document',
    '/admin/confidential_document/create' => 'Admin@createRequest',
    '/admin/confidential_document/approve/{document_id}' => 'Admin@approveRequest',
    '/admin/confidential_document/deny/{document_id}' => 'Admin@denyRequest',
    '/admin/confidential_document/delete/{document_id}' => 'Admin@deleteRequest',

    '/admin/confidential_document/requests/getAll' => 'Admin@getAllRequests',
    '/admin/confidential_document/files/getAll' => 'Admin@getAllFiles',

    /* Messages */
    '/message/getRecepient/{user_id}' => 'Message@getRecepient',

    '/messages/partner/recepients' => 'Message@getPartnerRecepients',
    '/messages/partner/recepients/search' => 'Message@getPartnerRecepients1',
    
    '/messages/admin/recepients' => 'Message@getAdminRecepients',
    '/messages/admin/recepients/search' => 'Message@getAdminRecepients1',
    
    '/messages/student/recepients' => 'Message@getStudentRecepients',
    '/messages/student/recepients/search' => 'Message@getStudentRecepients1',
    
    '/messages/send_message' => 'Message@sendMessage',
];
