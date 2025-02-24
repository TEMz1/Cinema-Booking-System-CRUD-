<?php
define('APP_ACCESS', true);
?>

<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['USER_ID'])) {
    header("location:login.php");
    exit();
}


// Validasi session
if (isset($_SESSION['hall_id']) && isset($_SESSION['transaction_id'])) {
  $hall_no = $_SESSION['hall_id'];           // Ambil dari session
  $transaction_id = $_SESSION['transaction_id']; // Ambil dari session

 // Query untuk menghapus data
 $sql = "DELETE FROM bookings WHERE transaction_id = ? AND hallNo = ?";
 $stmt = mysqli_prepare($conn, $sql);

 if ($stmt) {
     // Bind parameter
     mysqli_stmt_bind_param($stmt, "ss", $transaction_id, $hall_no);

     // Eksekusi query
     mysqli_stmt_execute($stmt);
 }
  // Hapus session terkait (Opsional)
  unset($_SESSION['hall_id']);
  unset($_SESSION['transaction_id']);
}

// Jika terdapat sesi transaction_id, hapus data terkait di database
if (isset($_SESSION['transaction_id'])) {
  $transaction_id = $_SESSION['transaction_id'];

  // Hapus data di database berdasarkan transaction_id
  $query = "DELETE FROM invoice WHERE transaction_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $transaction_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>TEN | Privacy Policy</title>
     <!-- ::::::::::::::Icon Tab::::::::::::::-->
     <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/_navbarStyles.css" />
    <link rel="stylesheet" href="assets/_footerStyles.css" />
    <style>
    body {
      color: white;
    }
    .text-muted {
      color: #6c757d!important;
    }

</style>

</head>
<body id="page-top" class="index" data-pinterest-extension-installed="cr1.3.4">
      <!-- HEADER SECTION -->
      <?php include('header.php') ?>
  
      <div class="container my-4">
        <div class="row">
          <div class="col-lg-12">
            <h1>Privacy Policy</h1><br>
            <h4>TEN Cinema's Privacy Policy and Personal Data Notice</h4><br><hr><br>
            <p>The privacy and personal data policy and practices of TEN Cinema's Cinemas Sdn. Bhd., TEN Movies Sdn Bhd, and its affiliated/ related companies (TEN) set out in this Privacy Policy and Personal Data Notice apply to all personal data provided to TEN, whether in electronic form or otherwise. By visiting and/or using www.TEN.co.id and www.TENmovies.co.id (TEN’s Website), any mobile applications run and maintained by TEN (TEN Mobile Application), and other services provided by TEN as well as by providing personal data to TEN, you agree to be bound by the terms and conditions of this Privacy Policy and Personal Data Notice. If you do not agree to such terms and conditions, please do not use or access TEN's Website or TEN Mobile Application, use the services provided by TEN or provide any personal data to TEN.
                </p><p>
                TEN’s collection of your personal data is part of its normal operation of TEN’s services. TEN has developed this Privacy Policy to inform you about TEN’s policy and practices on personal data and privacy matters and because TEN believes that you should know as much as possible about such matters so that you can make informed decisions.
                <br></p><p>
                Notice
                This written notice serves to inform you that your personal data is being processed by or on behalf of TEN. For the purposes of this written notice, the terms “personal data” and “processing” shall have the meaning assigned to them in the Personal Data Protection Act 2010 (hereinafter referred to as the “PDPA”).
                </p><p>
                <h4>Description of your personal data</h4>
                Your personal data processed by TEN includes:-
                
                </p><p>
                1.your personal details such as name, gender, identification support documents (including NRIC or passport number), date of birth, race, nationality, country, marital status, occupation and contact details (such as current residential or business address, e-mail address, and phone numbers);<br>
                2.your feedback information gathered from multiple sources such as e-mail, phone and write-in;<br>
                3.your visits to TEN’s Websites/ TEN Mobile Application – name of internet service provider, the website from which you visit TEN Website/ TEN Mobile Application, the pages and content which you view, the date and duration of your visit, cookies to track usage patterns, etc from the analytics tools such as Google Analytics and others;<br>
                4.your personal interests and preferences to help TEN design the offering of its products;<br>
                5.recording of your image via CCTV cameras when you visit TEN cinemas;<br>
                6.your curriculum vitae or resume when you register your interest in having a career in TEN and/or its relevant subsidiary/subsidiaries; and <br>
                7.information given voluntarily by you during any on-ground promotions or digital activities, tie-ups, contests, etc.
                </p><p>
                <h4>Purposes for the processing of your personal data</h4>
                TEN may process your personal data collected from you or from any of the class of third parties stated in this Privacy Policy, for any one or more of the following purposes (hereinafter referred to as the “Purposes”):-
                </p>
                1.To verify your identity; <br>
                2.To communicate with you and deliver information that is requested by you to you and/or, in some cases, is targeted to your interests, such as targeted banner advertisements, administrative notices, product offerings, and communications relevant to your use of TEN’s Website, TEN Mobile Application and or TEN services; <br>
                3.To process any communication you send to TEN (for example, answering any queries, dealing with any complaints and/or feedbacks); <br>
                4.To notify and/or invite you to events or activities organized by TEN, its partners or sponsors; <br>
                5.To notify you about benefits, changes to the features, promotions, alerts, newsletter, updates, promotional materials and, special privileges; <br>
                6.To send you festive greetings and movie-related content; <br>
                7.To run TEN’s customer loyalty programmes where applicable; <br>
                8.To establish and better manage any business relationship TEN may have with you; <br>
                9.To help TEN monitor and improve its services to you, TEN’s customer service teams, TEN’s Website and TEN Mobile Application and other TEN related assets and services, and to facilitate and conduct TEN’s staff training and TEN’s quality control and audits; <br>
                10.To conduct marketing activities (for example, market research and surveys); <br>
                11.To maintain records required for auditing, security, claims and/or other legal purposes; <br>
                12.To investigate and resolve any ticketing issues or otherqueries or complaints that you may submit to or raise with TEN; <br>
                13.To investigate, respond to, and/ or defend claims made against, or involving TEN; <br>
                14.For compliance with and/or any purposes required by any relevant law, directives, guidelines, orders, rules, regulations and requirements of any governmental or statutory authority or administrative or regulatory or supervisory body (including disclosure thereunder); <br>
                15.To process and facilitate any payment and transactions with TEN including the purchase of movie tickets and other products or services from TEN; and <br>
                16.In a situation where you have applied for a job with us via TEN’s Website, to evaluate your suitability for the position applied for at TEN, for the general record keeping purposes of the Human Resource Department as well as for other purposes relating or incidental to employment with TEN, whether or not you are subsequently employed and <br>
                17.Any other purposes relating or incidental to any of the above. <br></p>
                 
                <h4>Source of your personal data</h4>
                <p>Your personal data is collected directly from you when you:-</p>
                
                1.interact and communicate with TEN at any of its events or activities; <br>
                2.communicate with TEN whether through email, phone, TEN’s Website or TEN Mobile Application, social media such as Facebook, Twitter and Instagram as well as other forms of communication; <br>
                3.register or subscribe for a specific service or publications of TEN (for example, newsletter or TEN membership registration); <br>
                4.participate in any of TEN’s surveys, polls or other similar vehicles used to improve the content of TEN’s Website/TEN Mobile Application or used for TEN’s marketing purposes; <br>
                5.enter or participate in any competitions, contests or loyalty programmes organized by TEN; <br>
                6.register your interest and/or request for information through TEN’s Website or TEN Mobile Application, online portals or other available channels; <br>
                7.respond to any marketing materials that TEN sends out; <br>
                8.visit or browse TEN’s website and any other TEN owned platforms; <br>
                9.lodge a complaint with TEN; and <br>
                10.provide feedback to TEN (for example via TEN’s website or in hard copy). <br> </p>
                 
                <p>Other than the personal data obtained from you directly as stated above, TEN may also obtain your personal data from third parties which TEN deals with or are connected with you, and from such other sources where you have given your consent for the disclosure of your personal data and/or where otherwise lawfully permitted.</p>
                
                <h4>Your rights</h4>
                <p>You have the following rights in relation to your Personal Data:-</p>
                
                1.to make a data request in writing to TEN for information of your personal data that is being processed by or on behalf of TEN (Section 30(2) of PDPA); <br>
                2.to correct any of your personal data which is inaccurate, incomplete, misleading or not up-to-date (Section 34(1) of PDPA) TEN’s website by completing the Personal Data Update Form and emailing it to TEN at cs@TEN.co.id  .; <br>
                3.to limit the processing of your personal data including the personal data relating to other persons who may be identified from your personal data (Section 7(1)(f) of PDPA); and <br>
                4.to request for your personal data to be removed from TEN’s database. <br> </p>
                 
                <p>If you have any request in relation to the abovementioned rights or any inquiries or complaints in respect of your personal data, please contact:</p>
                
                <h5>Customer Relations</h5>
                
                (6) 03 - 7713 7888 <br>
                <p>Email Address: cs@TEN.co.id</p>
                
                <p>TEN may refuse to comply with your data access request under the circumstances specified in the PDPA and if TEN does so, TEN will inform you of its refusal and the reason(s) for its refusal.</p>
                
                <h4>Class of third parties to TEN may disclose your personal data</h4>
                <p>This is the class of persons to whom TEN may disclose your personal data:-</p>
                
                1.Third party service provider(s) for the provision of administrative, communications, payment, event management, security, information technology (IT), data processing or other services to TEN. <br>
                2.Any third party or company that TEN engages or appoints to conduct statistical analysis; <br>
                3.TEN’s business partners in relation to any products offered by TEN or the said business partner, including Hong Leong Bank in relation to the TEN-Hong Leong Bank Credit Card <br>
                4.Lawyers for the enforcement of TEN’s legal rights; and <br>
                5.Such other authorities, bodies or parties when required by law. <br> </p>
                 
                <p>Your Personal Data is collected and processed to provide you with TEN services and to facilitate the Purposes pursuant to your request. Such recipients of your Personal Data are contractually prohibited from using Personal Data for any purpose other than for the purpose TEN specifies.</p>
                
                <h4>Your obligations</h4>
                <p>1.Unless otherwise specified, it is obligatory for you to supply TEN with your personal data and your failure to do so will result in TEN being unable to process your personal data for any of the Purposes. <br>
                2.You will take reasonable steps to ensure that your personal data is accurate, complete, not misleading and kept up-to-date (Section 11 of PDPA).
                </p>
                <h4>Security of your personal data</h4>
                <p>TEN, when processing your personal data, takes practical steps to protect your personal data from any loss, misuse, modification, unauthorized or accidental access or disclosure, alteration or destruction including but not limited to the use of procedural and technical safeguards such as encryption, “firewalls” and secure socket layers. If you are aware of any security breach, please let us know as soon as possible.</p>
                
                <p>However, “perfect security” does not exist on the internet, so TEN does not give an absolute assurance that your personal data that you provide to TEN will be secure at all times, and TEN will not be responsible for any event arising from unauthorised access to or theft of your personal data. TEN will not be held responsible for events arising from third parties gaining unauthorised access to or third parties’ theft of your personal data.</p>
                
                <h4>Retention of your personal data</h4>
                <p>TEN will keep your personal data for the duration that is necessary for the Purposes set out in this Privacy Policy and Personal Data Notice.</p>
                
                <h4>Amendment to this Privacy Policy and Personal Data Notice</h4>
                <p>TEN reserves the right to amend this Privacy Policy and Personal Data Notice at any time by posting an amended Privacy Policy and Personal Data Notice containing such amendments on TEN’s Website or by any other mode TEN deems suitable.</p>
                
                <h4>Users under the age of 18</h4>
                <p>The TEN website and its related services are not directed at persons under 18 years of age. </p>
                
                <h4>Inconsistency or conflict</h4>
                <p>In the event of any inconsistency or conflict between the English language version and the Bahasa Malaysia version, the English language version shall prevail.</p>
                
                <h4>Others rights</h4>
                <p>For avoidance of doubt, nothing in this Privacy Policy and Personal Data Notice shall limit such other rights of yourself or TEN under the PDPA.</p>
                
                <h4>Links to other websites</h4>
                <p>When you use a link from TEN’s Website/ TEN Mobile Application to another third party website, this Privacy Policy is no longer in effect. Once you have used such link, TEN does not have any control over that other third party website and TEN cannot and shall not be liable or responsible for the protection and privacy of any personal data which you provided whilst visiting such website(s). Your browsing of and interaction on any other third party website(s) will be subject to that websites’ own rules and policies.</p>  
                
                <h4>Cookies</h4>
                <p>“Cookies” are text files to store your preferences that are placed in the browser of your device. TEN’s Website or TEN Mobile Application may use Cookies to enhance your experience and understand the usage of the TEN’s Website or TEN Mobile Application. Cookies will not provide us with personally identifiable information unless you choose to provide such Personal Data to TEN. Once Personal Data is furnished, however, this information may be linked to the data stored in the Cookie.</p>
                
                <h4>Usage tracking and Log Files</h4>
                <p>TEN’s web server automatically collects information on your domain type, browser used and your IP address for statistical purposes only, which will be used to improve the content of the TEN Website or TEN Mobile Application and not sold to other organizations for any purpose. </p>
                
                <p>As with most other websites, TEN collects and uses the data contained in log files. The information in the log files include your IP (internet protocol) address, your ISP (internet service provider), the browser you used to visit the TEN’s Website, your screen resolutions and number of colors, the time you visited the Website and which pages you have visited throughout the TEN’s Website.</p>
                
                <h4>Processing of Personal Data</h4>
                <p>Your Personal Data may be transferred to another country as part of the processing of Personal Data. The jurisdictions in which the Personal Data or information is processed may or may not have laws to regulate the privacy of personal data, however, whenever your Personal Data is transferred by TEN and/or TEN third party service providers, TEN will use its best endeavor to ensure that your Personal Data is processed in accordance with the terms and conditions of this Policy.</p>
           </div>
         </div>
      </div>

          <!-- FOOTER SECTION -->
    <?php include('footer.php') ?>
</body>
</html>
