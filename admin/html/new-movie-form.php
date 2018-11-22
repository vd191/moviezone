<form method="POST" name='movie' enctype="multipart/form-data">
<div class="new-movie-form">
    <fieldset>
    <legend>New movie</legend>
    <div class='new-movie'>
        <div class="id-thumbnail-container">
            
            
        </div>

        <div class='new-movie-container'>
            <div class='new-movie-label'>
                <label for="thumbnail">Image</label>
                
            </div>
                
            <div class='new-movie-field'>    
                <img class='thumbnail-new-movie'  id='id_photo_frame'  height='300' width='200' style='float:right; margin-bottom: 10px;' >
                <p ><label>Movie Poster<br> (200px x 300px)</label></p>
                <input type='file' id="id-photo" name='photo_loader' onchange='loadPhoto(this);' style='float:right; border: solid 0.1px rgb(241, 241, 241);' ><br><br>
            </div>
        </div>

        <div class='new-movie-container'>
            <div class='new-movie-label'>
                <label for="title">Title:</label> <br><br>
                <label for="year">Year:</label> <br><br>
                <label for="tagline">Tagline:</label><br><br>
                <label for="plot">Plot:</label> <br><br>
                <label for="classification">Classification:</label> <br>
            </div>
                
            <div class='new-movie-field'>    
                <input type="text" name="title" placeholder="ex: Inception" id="id-title" class="id-new-movie-textfield"> <br>
                <input type="text" name="year" placeholder="ex: 2010" id="id-year" class="id-new-movie-textfield"> <br>
                <input type="text" name="tagline" placeholder="ex: A thief who steals" id="id-tagline" class="id-new-movie-textfield"> <br>
                <input type="text" name="plot" placeholder="ex: Through the use of dream-sharing technology" id="id-plot" class="id-new-movie-textfield"> <br>
                <!-- <textarea name="plot" id="id-plot-textfield" cols="50" rows="5">e.g. Through the use of dream-sharing technology..</textarea><br> -->
                <input type="text" name="classification" placeholder="ex: M" id="id-classification" class="id-new-movie-textfield"> <br>
            </div>
        </div>
        
        

        <!-- <div id='id-select-box-content'> </div> -->


        <div class='new-movie-container'>
            <div class='new-movie-label'>
                <label for="director">Director:</label><br><br>
                <label for="studio"> Studio:</label>  <br><br>
                <label for="genre">Genre:</label> <br><br>
            </div>

            <div class='new-movie-field'>  
                <input type="text" name="director"  id="id-director" class="id-new-movie-textfield"> <br>
                <input type="text" name="studio"  id="id-studio" class="id-new-movie-textfield"> <br>
                <input type="text" name="genre"  id="id-genre" class="id-new-movie-textfield"> <br>
            </div>
        </div>

        <div class='new-movie-container'>
            <div class='new-movie-label'>
                <label for="rental_period">Rental Period:</label> <br>  <br>    
            </div>
            <div class='new-movie-field'>  
                <input type="text" name="rental_period" placeholder="ex: Weekly" id="id-rental-period" class="id-new-movie-textfield"> <br>
            </div>    
        </div>
    </div>
    </fieldset> 

    <fieldset>
    <legend>Actor</legend>
        <div class='actor'>  
            <div class='new-movie-container'>       
                <div class='new-movie-label'>
                    <!-- <label for="costar1">Star1:</label> <br>  <br>  
                    <label for="costar2">Star2:</label><br>  <br>  
                    <label for="costar3">Star3:</label><br>  <br>  

                    <label for="costar1">costar1:</label> <br>  <br>  
                    <label for="costar2">costar2:</label><br>  <br>  
                    <label for="costar3">costar3:</label><br>  <br>   -->
                    
                    <label for="costar1">Star1:</label> <br>  <br>  
                    <label for="costar2">Star2:</label><br>  <br>  
                    <label for="costar3">Star3:</label><br>  <br>  

                    <label for="costar1">Costar1:</label> <br>  <br>  
                    <label for="costar2">Costar2:</label><br>  <br>  
                    <label for="costar3">Costar3:</label><br>  <br>  
                </div>

                <div class='new-movie-field'>  
                    <!-- <div id='id-select-box-star1'> <select name='box-star1' id='id-star1-box'> </select>  <br> <br>    </div>
                    <div id='id-select-box-star2'> <select name='box-star2' id='id-star2-box'> </select> <br> <br>     </div>
                    <div id='id-select-box-star3'> <select name='box-star3' id='id-star3-box'> </select> <br> <br>      </div>

                    <div id='id-select-box-costar1'> <select name='box-costar1' id='id-costar1-box'> </select>  <br> <br>   </div>
                    <div id='id-select-box-costar2'> <select name='box-costar2' id='id-costar2-box'> </select>  <br> <br>   </div>
                    <div id='id-select-box-costar3'> <select name='box-costar3' id='id-costar3-box'> </select>  <br> <br>   </div> -->

                    <input type="text" name="star1"  id="id-star1" class="id-new-movie-textfield"> <br>
                    <input type="text" name="star2"  id="id-star2" class="id-new-movie-textfield"> <br>
                    <input type="text" name="star3" id="id-star3" class="id-new-movie-textfield"> <br>

                    <input type="text" name="costar1"  id="id-costar1" class="id-new-movie-textfield"> <br>
                    <input type="text" name="costar2" id="id-costar2" class="id-new-movie-textfield"> <br>
                    <input type="text" name="costar3"  id="id-costar3" class="id-new-movie-textfield"> <br>
                </div> 
            </div>
        </div>    
    </fieldset>   

    <fieldset>
    <legend>Stock Information</legend>
        <div class='stock-information'>
              
            <div class='dvd-info'>
                <fieldset>
                    <legend>DVD Information</legend>
                    <div class='new-movie-label'>
                        <label for="dvd_rental_price">Rental Price:</label> <br>  <br>  
                        <label for="dvd_purchase_price">Purchase Price:</label><br>  <br>  
                        <label for="numdvd">In-Stock:</label><br>  <br>  
                    </div>

                    <div class='new-movie-field'>  
                        <input type="text" name="dvd_rental_price" placeholder="ex: 5.00" id="id-dvd-rental-price" class="id-new-movie-textfield"> <br>
                        <input type="text" name="dvd_purchase_price" placeholder="ex: 15.00" id="id-dvd-purchase-price" class="id-new-movie-textfield"> <br>
                        <input type="text" name="numdvd" placeholder="ex: 10" id="id-numdvd" class="id-new-movie-textfield"> <br>
                    </div>
                </fieldset> 
            </div>
                
            <div class='bluray-info'>
                <fieldset>
                    <legend>Bluray Information</legend>
                    <div class='new-movie-label'>
                        <label for="bluray_rental_price">Rental Price:</label> <br>  <br>  
                        <label for="bluray_purchase_price">Purchase Price:</label><br>  <br>  
                        <label for="numbluray">In-Stock:</label>  <br>  
                    </div>

                    <div class='new-movie-field'>
                        <input type="text" name="bluray_rental_price" placeholder="ex: 30.00" id="id-bluray-rental-price" class="id-new-movie-textfield"> <br>
                        <input type="text" name="bluray_purchase_price" placeholder="ex: 50.00" id="id-bluray-purchase-price" class="id-new-movie-textfield"> <br>
                        <input type="text" name="numbluray" placeholder="ex: 20" id="id-numbluray" class="id-new-movie-textfield"> <br>  
                    </div>
                </fieldset>
            </div>
            
        </div>    
    </fieldset>      
       
    
    <div class='new-movie-btn'>
        <input type='submit'  name='btnSubmit' class='btn-delete-edit' value='SUBMIT' > 
       
        <input type='submit'  name='btnExit' class='btn-delete-edit'  value='EXIT'  style='background-color:tomato'> 
      
    </div>
    

</div>   

</form>