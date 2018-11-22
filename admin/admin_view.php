<?php

/**
 * Class View
 */
Class View
{
    /**
     * @param $error
     */
    public function showError($error)
    {
        print "<h5>Error: $error</h5>";
    }

    /**
     * @param $results
     */
    public function showNotification($result)
    {
        if($result){
            print "_OK_";
        }else{
            print "<h5>_ERROR_</h5>";
        }
        
    }

    /**
     * Render new movie form
     */
    public function showNewMovieForm()
    {
        include 'html/new-movie-form.php';
    }

    /**
     * Render new movie form
     */
    public function showAdminIndex()
    {
        include 'testadminindex.php';
    }

    /**
     *
     */
    public function showNewUserForm()
    {
        include 'html/new-user-form.html';
    }

    /**
     * @param $movieArray
     */
    public function showMovie($movieArray)
    {
        if (!empty($movieArray)) {
            foreach ($movieArray as $movie) {
                $this->printInHtml($movie);
            }
        }
    }

    /**
     * @param $users
     */
    public function showUser($users)
    {
        if (!empty($users)) {
            foreach ($users as $user) {
                $this->printUserInHtml($user);
            }
        }
    }
    public function actorsSelectBoxPanel($actors)
    {   
        print "
             
            <option value='all'> Actor </option> 
        ";
            foreach ($actors as $actor) {
                print "
                    <option value='".$actor['actor_id']."'> ".$actor['actor_name']." </option>
                ";
            }   
    }

    public function selectBoxPanel($directors, $studios, $genres)
    {
        print "
        <div class='new-movie-container'>
            <div class='new-movie-label'>
                <label for='director-box'>Director</label> <br><br>
                <label for='genre-box'> Genre</label>  <br><br>
                <label for='studio-box'> Studio</label>  <br><br> 
            </div>

            <div class='new-movie-field'> 
                <select name='director-box' id='id-director-box'>   
                <option value='all'> Director </option> 
        "; 
                foreach ($directors as $director) {
                    print "
                        <option value='".$director['director_id']."'> ".$director['director_name']." </option>
                    ";
                }
        print "
                </select> <br> <br>   
                <select name='genre-box' id='id-genre-box'>
                <option value='all'> Genre </option>
        ";
                foreach ($genres as $genre) {
                    print "
                        <option value='".$genre['genre_id']."'> ".$genre['genre_name']." </option>
                    ";
                }
        print "     
                </select><br> <br> 
                <select name='studio-box' id='id-studio-box'>  
                        <option value='all'> Studio </option>  
        ";
                foreach ($studios as $studio) {
                print "
                    <option value='".$studio['studio_id']."'> ".$studio['studio_name']." </option>
                    ";
                }
        print "
                </select>   
            </div>
        </div>
        
        ";
    }


    /**
     * @param $result
     */
    public function printInHtml($result)
    {

        if (empty($result['thumbpath'])) {
            $photo = _MOVIES_PHOTO_FOLDER_."default.jpg";
        } else {
            $photo = _MOVIES_PHOTO_FOLDER_.$result['thumbpath'];
        }
        $movieID = $result['movie_id'];
        $title = $result['title'];
        $rental_period = $result['rental_period'];
        $genre = $result['genre'];
        $year = $result['year'];
        $director = $result['director'];
        $classification = $result['classification'];
        $star1 = $result['star1'];
        $star2 = $result['star2'];
        $star3 = $result['star3'];
        $costar1 = $result['costar1'];
        $costar2 = $result['costar2'];
        $costar3 = $result['costar3'];
        $studio = $result['studio'];
        $tagline = $result['tagline'];
        $plot = $result['plot'];
        $dvdRental = $result['DVD_rental_price'];
        $blurayRental = $result['BluRay_rental_price'];
        $dvdPurchase = $result['DVD_purchase_price'];
        $blurayPurchase = $result['BluRay_purchase_price'];
        $numberDvd = $result['numDVD'];
        $numberDvdOut = $result['numDVDout'];
        $numberBluray = $result['numBluRay'];
        $numberBlurayOut = $result['numBluRayOut'];

        $dvdAvailability = ($numberDvd - $numberDvdOut);
        $blurayAvailability = ($numberBluray - $numberBlurayOut);

        echo "
            <div class='movie-container'>
                <div class='thumbnail-movie'>
                    <img src='$photo' id='image-movie'>
                </div>

                <div class='title-movie'>
                    <span id='id-movie-title'> $title ($year) </span> <br>
                    <span id='id-movie-subtitle'> Director: $director </span>
                </div>

                

                <div class='check-box'>
                    <button type='button' onclick='editmovie($movieID);' name='btnSubmit' class='btn-delete-edit'  > <span id='edit-text'>EDIT</span> </button>
                    <button type='button' onclick='deletemovie($movieID);' name='btnExit' class='btn-delete-edit'  style='background-color:tomato'> <span id='edit-text'>DELETE</span> </button>
            
                   
                </div>
            </div>
        ";

    }

    /**
     * @param $result
     */
    public function printUserInHtml($result)
    {
        $memberid = $result['member_id'];
        $surname = $result['surname'];
        $othername = $result['other_name'];
        $occupation = $result['occupation']; 

        echo "
        <div class='user-container'>

            <div class='user-info'>
                <span id='id-user-title'> $surname </span> <br>
                <span id='id-user-subtitle'> $othername </span>
            </div>

            <div class='occupation'>
                <span id='id-user-title'> $occupation </span> <br>
                <span id='id-user-subtitle'> Occupation </span>
            </div>



            <div class='check-box'>
               
                    <input type='submit' onclick='editUser($memberid)' name='btnSubmit' class='btn-delete-edit' value='EDIT'  > 
                    <input type='submit'  onclick='deleteUser($memberid)' name='btnExit' class='btn-delete-edit' value='DELETE' style='background-color:tomato'>
             
            </div>

           
        </div>
        
        ";
    }

    

    public function showEditUserForm($result){
        if (!empty($result)) {
            foreach ($result as $key) {
                $this->printUserEditForm($key);
            }
        } 
    }


    public function showEditMovieForm($movieID){
      print "
      <p>  Only change MovieID when you would like to edit another movie </p>
        <form method='POST' name='editMovieStock' enctype='multipart/form-data'>
        <div class='new-movie-form'>
            <span id='content-text'>   </span>
            
            <div class='new-movie-label'>
                <label for='dvd_rental_price'>Movie ID:</label> <br>  <br>  
            </div>

            <div class='new-movie-field'>  
            
                <input type='text' name='movieid' value='$movieID' id='id-movieid' class='id-new-movie-textfield' > <br>
            </div>

            <div class='stock-information'>
                
                <div class='dvd-info'>
                    <fieldset>
                        <legend>DVD Information</legend>
                        <div class='new-movie-label'>
                        
                            <label for='dvd_rental_price'>Rental Price:</label> <br>  <br>  
                            <label for='dvd_purchase_price'>Purchase Price:</label><br>  <br>  
                            <label for='numdvdout'>Currently rented:</label><br>  <br>  
                        </div>

                        <div class='new-movie-field'>  
                        
                            <input type='text' name='dvd_rental_price' value='5.00' id='id-dvd-rental-price' class='id-new-movie-textfield'> <br>
                            <input type='text' name='dvd_purchase_price' value='15.00' id='id-dvd-purchase-price' class='id-new-movie-textfield'> <br>
                            <input type='text' name='numdvdout' value='10' id='id-numdvd' class='id-new-movie-textfield'> <br>
                        </div>
                    </fieldset> 
                </div>
                    
                <div class='bluray-info'>
                    <fieldset>
                        <legend>Bluray Information</legend>
                        <div class='new-movie-label'>
                            <label for='bluray_rental_price'>Rental Price:</label> <br>  <br>  
                            <label for='bluray_purchase_price'>Purchase Price:</label><br>  <br>  
                            <label for='numblurayout'>Currently rented:</label>  <br>  
                        </div>

                        <div class='new-movie-field'>
                            <input type='text' name='bluray_rental_price' value='30.00' id='id-bluray-rental-price' class='id-new-movie-textfield'> <br>
                            <input type='text' name='bluray_purchase_price' value='50.00' id='id-bluray-purchase-price' class='id-new-movie-textfield'> <br>
                            <input type='text' name='numblurayout' value='20' id='id-numbluray' class='id-new-movie-textfield'> <br>  
                        </div>
                    </fieldset>
                </div>

                <input type='submit' onclick='editStock();' name='btnEditMovieSubmit' class='btn-delete-edit' value='SUBMIT' style='margin-top:20px'> 
                
            </div>    
        


        </div>
        </form>  
        ";      
    }

    public function printUserEditForm($result){
        if (!empty($result)) {
            $memberid = $result['member_id'];
            $surname = $result['surname'];
            $othername = $result['other_name'];
            $contactMethod = $result['contact_method'];
            $email = $result['email'];
            $phone = $result['mobile'];
            $landline = $result['landline'];
            $magazine = $result['magazine'];
            $street = $result['street'];
            $suburb = $result['suburb'];
            $postcode = $result['postcode'];
            $username = $result['username'];
            $password = $result['password'];
            $joinDate = $result['join_date'];
            $occupation = $result['occupation']; 

            echo "
                <div class='new-user-form'>
                    <div class='form'>
                        <div class='form-content'>
                            <h4 id='signup-mess'>  You are editing UserID: $memberid </h4>
                            <div class='name'>
                                <div class='name-label'>
                                    <label for='surname'>Surname:</label><br><br>
                                    <label for='other-name'>Other Name:</label><br><br>
                                    <label for='occupation'>Occupation: </label>
                                </div>
            
                                <div class='name-field'>
                                    <div class='surname'>
                                        <input  type='text' class='text-field-input'  name='surname' id='id-signup-surname' required autofocus value='$surname'>
                                        <br>
                                    </div>
                                        
                                    <div class='othername'>
                                        <input type='text' class='text-field-input'   name='other-name'  id='id-signup-other-name' required value='$othername'> 
                                        <br>
                                    </div>
                    
                                    <div class='user-occupation'>
                                        <input type='text'  class='text-field-input'   name='user-occupation'  id='id-signup-occupation' required value='$occupation'>
                                        <br>
                                    </div>
                                </div>   
                            </div>

                        <div class='user-contact'>
                            <h4 id='signup-mess'> Preferred Contact Method
                                <div class='contact-checkbox' style='float:right;margin-right:10px;color: black'>
                                    <input type='radio' name='contact-checkbox' id='id-signup-phone-contact' onclick='contactIsChecked();'><span>Phone</span> 
                                    <input type='radio' name='contact-checkbox' id='id-signup-landline-contact' onclick='contactIsChecked();'><span>Landline</span> 
                                    <input type='radio' name='contact-checkbox' id='id-signup-email-contact' onclick='contactIsChecked();'><span>Email</span> 
                                </div>
                            </h4>  
                            
        
                            <div class='contact-label'>
                                    <label for='phone'>Phone: </label><br><br>
                                    <label for='landline'>Landline: </label><br><br>
                                    <label for='email'>Email: </label>
                            </div>
        
                            <div class='contact-field'>
                                <div class='phone-contact'>
                                    <div class='phone-tooltip'>
                                        <input class='text-field-input' type='text' name='phone' placeholder='Enter Your Phone Number' id='id-signup-phone' value='$phone' >
                                        <span class='phone-tooltiptext'>Format: 0[4 or 5] XXXX-XXXX, 0[4 or 5]XXXXXXXX, 0[4 or 5]XXXX-XXXX, 0[4 or 5]XXXX XXXX</span>      
                                        </div>
                                    <br>
                                </div>
                                    
                                <div class='landline-contact'>
                                    <div class='landline-tooltip'>
                                        <input class='text-field-input' type='text' name='landline' placeholder='Enter Your Landline Number' id='id-signup-landline' value='$landline'>
                                        <span class='landline-tooltiptext'>Format: 0[2,3,6,7,8,9] XXXX-XXXX, 0[2,3,6,7,8,9]XXXXXXXX, 0[2,3,6,7,8,9]XXXX-XXXX, 0[2,3,6,7,8,9]XXXX XXXX</span>      
                                    </div>
                                    <br>
                                </div>
                                
                                <div class='email-contact'>
                                    <input class='text-field-input' type='text' name='email' placeholder='Enter Your Email' id='id-signup-email' value='$email' >
                                    <br>
                                </div>
        
                            </div>  
                        </div> 


                        <div class='address'>
                            <h4 id='signup-mess'> Do you want to receive our monthly magazine?
                                    <div class='address-checkbox' style='float:right;margin-right:10px;color: black'>
                                        <input type='checkbox' name='magazine' id='id-signup-magazine' onchange='magazineIsChecked();'> <span>Yes</span> 
                                    </div>
                            </h4>

                            <div class='address-label'>
                                <label for='street'>Street Address:</label><br><br>
                                <label for='suburb'>Suburb and State:</label><br><br>
                                <label for='postcode'>Postcode:</label><br>
                            </div>

                            <div class='address-field'>
                                <div class='street'>
                                    <input class='text-field-input' type='text' name='street' placeholder='Do Not Enter Here' id='id-signup-street' value='$street' >
                                    <br>
                                </div>
                
                                <div class='suburb'>  
                                    <input class='text-field-input' type='text' name='suburb' placeholder='Do Not Enter Here' id='id-signup-suburb' value='$suburb' >
                                    <br>
                                </div>
                                
                                <div class='postcode'>
                                    <input class='text-field-input' type='text' name='postcode' placeholder='Do Not Enter Here' id='id-signup-postcode' value='$postcode' >
                                    <br>
                                </div>
                            </div>
                        </div>
            


                        <div class='password'>
                            <div class='password-label'>
                                <label for='username'>Username:</label><br><br>
                                <label for='password'>Password:</label><br><br>
                                <label for='verify-password'>Verify Password:</label>
                            </div>

                            <div class='password-field'>
                                <div class='username'>
                                    <input class='text-field-input' type='text' name='username' placeholder='Enter Your Username' id='id-signup-username' value='$username'>
                                    <br>
                                </div>
                
                                <div class='pass'>
                                    <div class='password-tooltip'>
                                        <input class='text-field-input' type='text' name='password' placeholder='Enter Your Password' id='id-signup-password' value='$password'>
                                        <span class='password-tooltiptext'>Must contain a number, a capital, a lowercase, minimum 3 characters</span>
                                    </div>
                                    <br>
                                </div>
                                    
                                <div class='vpass'>
                                    <input class='text-field-input' type='password' name='verify-password' placeholder='Verify Password' id='id-signup-verify-password' required>
                                    <br>
                                </div>
                            </div>
                        </div>



                        <input type='submit' value='EDIT' style='float:left' class='submit-button' onclick='validateSignUpForm(true,$memberid);'> 





                        </div>
                    </div>

                </div>
            
            ";   
        }
    }
}



