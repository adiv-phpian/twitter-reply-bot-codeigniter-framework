<?php
$this->load->view("site/header");

$tuser = json_decode($user->user_json);

//print_R($tuser);die;

?>
          <content>
            <div class="container">

                <div class="user-settings">

                    <div class="info-box-wrapper">

                        <form action="#" method="post" style="background:<?=$tuser->profile_background_color?>">
                            <h2>Settings</h2>

                            <style>
                            table{
                              margin: 0 auto;
                              padding: 5px 5px;
                              width: 100%;
                            }
                            tbody{
                              width: 100%;
                            }
                            table tr td{
                              padding: 5px 5px;
                            }
                            button.close-account:hover{
                              background-color: black;
                              color: white;
                            }
                            </style>

                            <table>
                              <tbody>

                              <tr>
                                 <td >Connected Twitter Account : @<?=$tuser->screen_name?></td>
                               </tr>
                              </tbody>
                             </table>

                             <br>

                             <input type="button" class="full-width medium" id="change_email" value="Change Email">


                             <input type="button" class="close-account full-width medium outline" id="close_account" value="Close account">

                             Note: If you close your DM Pilot, the same Twitter account cannot be used again in future

                        </form>
                      </div>
                  </div>
            </div>
        </content>

    </div>

<?php $this->load->view("site/footer"); ?>
