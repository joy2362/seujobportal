@component('mail::message')
{{$date}}<br>
Human Resources<br>
{{$job->company}}
{{$job->address}}

Subject: Application for the post of {{$job->name}}

Dear Sir/Madam,<br>
From your advertisement given Seujobportal, I came to know that you are going to recruit employees as {{$job->name}}. As a graduate I am very enthusiastic to join your renowned firm. My academic background and work attitude has equipped me as an excellent match for the aforesaid post.
My enclosed resume provides more details about my educational achievement and personal skills. If you find me as a right candidate in your consideration, please do not hesitate to email me at {{$user->email}}. Thank you for your time and I am looking forward to welcoming the opportunity for a further meeting.

Sincerely,<br>
{{$user->name}}

@endcomponent
