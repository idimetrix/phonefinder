<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->delete();

        $settings = [
            [
                'id' => '1',
                'key' => 'computer ads',
                'value' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- https phone finder UK RESPONSIVE 336X280 -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:336px;height:280px"
                     data-ad-client="ca-pub-4881586775108221"
                     data-ad-slot="5599377790"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>'
            ],
            [
                'id' => '2',
                'key' => 'computer ads top',
                'value' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- https phone finder UK RESPONSIVE LINK ADS -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-4881586775108221"
             data-ad-slot="4122644596"
             data-ad-format="link"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>'
            ],
            [
                'id' => '3',
                'key' => 'computer ads bottom',
                'value' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- https phone finder UK RESPONSIVE 336X280 -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:336px;height:280px"
                     data-ad-client="ca-pub-4881586775108221"
                     data-ad-slot="5599377790"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>'
            ],
            [
                'id' => '4',
                'key' => 'google analytics',
                'value' => '<script>
      (function (i, s, o, g, r, a, m) {
        i[\'GoogleAnalyticsObject\'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
          }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, \'script\', \'https://www.google-analytics.com/analytics.js\', \'ga\');
      ga(\'create\', \'UA-91828872-1\', \'auto\');
      ga(\'send\', \'pageview\');
    </script> '
            ], [
                'id' => '5',
                'key' => 'title',
                'value' => 'On this page you can find all the contact information.'
            ], [
                'id' => '6',
                'key' => 'description',
                'value' => 'Whether you’re looking for answers, would like to solve a problem, or just want to let us know how we did, you’ll find many ways to contact us right here. We’ll help you resolve your issues quickly and easily.'
            ], [
                'id' => '7',
                'key' => 'contacts',
                'value' => 'All information can be obtained by writing to us at mail: phonefinder.s@binka.ms or call us at +79310030824'
            ],
            [
                'id' => '8',
                'key' => 'phone ads',
                'value' => ''
            ],
            [
                'id' => '9',
                'key' => 'phone ads top',
                'value' => ''
            ],
            [
                'id' => '10',
                'key' => 'phone ads bottom',
                'value' => ''
            ],
            [
                'id' => '11',
                'key' => 'image logo',
                'value' => ''
            ],
            [
                'id' => '12',
                'key' => 'google review',
                'value' => ''
            ],
            [
                'id' => '13',
                'key' => 'button generate fake like',
                'value' => '0'
            ],
            [
                'id' => '14',
                'key' => 'details one',
                'value' => 'deliver crucial information to our customers as quickly and as accurately as possible.'
            ],
            [
                'id' => '15',
                'key' => 'details two',
                'value' => 'to find to find people\'s address, phone numbers, age guides, photos & more !'
            ],
            [
                'id' => '16',
                'key' => 'details three',
                'value' => 'Offical UK Telephone directory search platform'
            ],
            [
                'id' => '17',
                'key' => 'details four',
                'value' => 'to make a Facebook search query, and search for social profiles.'
            ],
            [
                'id' => '18',
                'key' => 'details extra four',
                'value' => 'Use'
            ],
            [
                'id' => '19',
                'key' => 'link one',
                'value' => '118118.com'
            ],
            [
                'id' => '20',
                'key' => 'link two',
                'value' => '192.com People Finder'
            ],
            [
                'id' => '21',
                'key' => 'link three',
                'value' => 'WhitePages.CO.UK'
            ],
            [
                'id' => '22',
                'key' => 'link four',
                'value' => 'THIS LINK'
            ],
            [
                'id' => '23',
                'key' => 'site name',
                'value' => 'PhonefinderUK'
            ],
            [
                'id' => '24',
                'key' => 'team name',
                'value' => 'Phone Finder UK Team'
            ],
            [
                'id' => '25',
                'key' => 'terms page',
                'value' => '<h1>Terms of use</h1>

    <p>These terms of use contain an arbitration clause and a class action waiver clause. By using this site, you are
        accepting the terms of use and, while you may still pursue claims against us, with a few exceptions (for
        example, if you submit a valid arbitration/class action waiver opt-out notice as described in section 19.5,
        below), you are agreeing that you must pursue your claims in a binding arbitration proceeding (and not in a
        court) and only on an individual (and not a class action) basis. See our FAQS for more information on the
        arbitration and class action waiver clauses. Please read these terms of use carefully to understand your rights
        and responsibilities.</p>

    <p>This is the official Terms of Use Agreement ("Agreement") for the website, application or other interactive
        service that includes an authorized link to this Agreement and all other websites, applications and other
        interactive services you also use that are offered by the specific VII Brand (as defined below) that is
        providing this website, application or other interactive service (collectively, all such websites, applications
        and other interactive services, "Site," "we," "us" or "our"). The Site is owned, operated and/or provided on
        behalf of the applicable VII Brand by Viacom International Inc. (Viacom International Inc., along with its
        Affiliates, shall be referred to collectively as "VII") through its Viacom Media Networks division, which offers
        television channel or programming services (such as television networks, websites, applications or other
        interactive services) and offers other products and services under various brands, such as those Viacom Media
        Networks brands and other VII brands listed here (each, a "VII Brand"). This Site together with the associated
        VII television channel or programming service, if any, shall be referred to collectively as the "Channel".
        "Affiliates" refers to Viacom International Inc.\'s parent company Viacom Inc. and all affiliates that Viacom
        Inc. directly or indirectly owns or controls (such as Paramount Pictures Corporation and the other affiliates of
        Viacom Media Networks as described in the link here).</p>'
            ],
            [
                'id' => '26',
                'key' => 'privacy page',
                    'value' => '<h1>Privacy Policy for the U.S. Equal Employment Opportunity Commission Web Site</h1>
    
        <p>We collect no personal information about you when you visit this site unless you choose to provide this information to us. Our web server software, and our content management system, do collect certain information automatically, and some of this information is made available to us. This information is outlined below.</p>
    
        <h2>Information collected and stored automatically:</h2>
    
        <p>If you visit our site to read or download information, the following information is collected automatically by the web server. None of this information is used to identify you.</p>
    
        <ul>
            <li>The name of Internet domain and IP address (an IP address is a number that is automatically assigned to your computer when you are connected to a network, such as the Internet). This information is used to help count the number of unique visits made to the site;</li>
    
            <li>The date and time that you access our site;</li>
    
            <li>The pages you visit (which helps us to determine what people are looking for);</li>
    
            <li>The web browser you use (which helps us to design our site to accommodate the broadest possible range of web browser software); and</li>
    
            <li>If you followed a link to get to us, the page you linked from (which helps us to determine how people are finding us, and how we can reach more people).</li>
        </ul>
    
        <p>All of this information is used to help us make our site more useful to visitors like you. We do not track or record information about individuals.</p>
    
        <h2>If you send us personal information:</h2>
    
        <p>If you choose to provide us with personal information, as in e-mail with a comment or question, or by filling out a form with your personal information and submitting it to us through our web site, we use that information to respond to your message and to help us get you the information you have requested. Electronic mail is not secure. Therefore, we suggest that you not send personal information to us via e-mail, especially social security numbers. We may share information you give us with contractors acting on our behalf or with another government agency if your inquiry relates to that agency. EEOC does not collect or use information for commercial marketing. We do not share our e-mail with any other organizations, unless we receive a request from an organization conducting a civil or criminal law enforcement investigation.</p>
    
        <h2>Use of cookies:</h2>
    
        <p>"Cookies" are small bits of text that are either used for the duration of the session ("session cookies"), or
            saved on a user\'s hard drive in order to identify that user, or information about that user, the next time the
            user logs on to a web
            site ("persistent cookies"). EEOC\'s websites do not use persistent cookies. Session specific cookies may be used
            to improve the user experience and for basic web metrics. These cookies expire in a very short time frame or
            when a browser window
            closes and are permitted by current federal guidelines.</p>
    
        <h2>Security:</h2>
    
        <p>We maintain a variety of physical, electronic and procedural safeguards to protect the security of this web site
            and any personal information you provide to us. For example, this Government computer system employs software
            programs to monitor
            network traffic to identify unauthorized attempts to upload or change information, or otherwise cause damage.
            Anyone using this system expressly consents to such monitoring and is advised that if such monitoring reveals
            evidence of possible abuse or
            criminal activity, such evidence may be provided to appropriate law enforcement officials. Unauthorized attempts
            to upload or change information on this server are strictly prohibited and may be punishable by law, including
            the Computer Fraud and
            Abuse Act of 1986, and the National Information Infrastructure Protection Act of 1996.</p>
    
        <h2>Changes to this policy:</h2>
    
        <p>We will revise or update this policy if our practices change. You should refer back to this page often for the
            latest information and the effective date of any changes. If we decide to change this policy, we will post a new
            policy on our site and
            change the date at the bottom. Changes to the policy shall not apply retroactively.</p>'
                ],
            [
                'id' => '27',
                'key' => 'tagged number safe',
                'value' => 'Safe caller'
            ],
            [
                'id' => '28',
                'key' => 'tagged number safe description',
                'value' => 'if you see a number listed with this label ,it means an OkCaller user has labelled the number as a \'safe\' contact. '
            ],
            [
                'id' => '29',
                'key' => 'tagged number unsafe',
                'value' => 'Unsafe caller'
            ],
            [
                'id' => '30',
                'key' => 'tagged number unsafe description',
                'value' => 'if you see a number listed with this label, it means an OkCaller user has labelled the number as a problematic contact. For example, it may be a telemarketer, bill collector, prank caller, or other nuisance caller.'
            ],
            [
                'id' => '31',
                'key' => 'link one path',
                'value' => 'http://www.118118.com/'
            ],
            [
                'id' => '32',
                'key' => 'link two path',
                'value' => 'http://www.192.com/people/'
            ],
            [
                'id' => '33',
                'key' => 'link three path',
                'value' => 'http://search.whitepages.co.uk/'
            ],
            [
                'id' => '34',
                'key' => 'link four path',
                'value' => 'https://www.facebook.com'
            ],
            [
                'id' => '35',
               'key' => 'computer ads above detailed',
                'value' => ''
            ],
            [
                'id' => '36',
                'key' => 'phone ads above detailed',
                'value' => ''
            ]
            ];

        DB::table('settings')->insert($settings);
    }

}