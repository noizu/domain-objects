<?php
namespace NoizuLabs\Core\Tests\Steps;
use NoizuLabs\PHPConform\PHPUnitExtension as PhpConform;

class Then extends PhpConform\StepAbstract
{


    //=========================================
    // Moderated Strings
    //=========================================
    /**
     * @Then the string should be in a pending state
     */
    public function ThenTheStringShouldBeInAPendingState()
    {
        if(is_null($this->moderatedString)) $this->fail("Moderated String Was Not Created"); 
        $this->assertTrue($this->moderatedString->hasPendingString());
    }

    /**
     * @Then the string should be in an approved state
     */
    public function ThenTheStringShouldBeInAnApprovedState()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then a ChangeLog entry should have been created
     */
    public function ThenAChangeLogEntryShouldHaveBeenCreated()
    {
        $this->assertTrue($this->moderatedString->getEntity()->getPendingText()->getId() > 0);
    }

    /**
     * @Then a ChangeLog approval entry should have been created
     */
    public function ThenAChangeLogApprovalEntryShouldHaveBeenCreated()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then a ModeratedString entry should have been created
     */
    public function ThenAModeratedStringEntryShouldHaveBeenCreated()
    {
        $this->assertTrue($this->moderatedString->getId() > 0);
    }
    
    //========================================
    // Banned IPs
    //========================================
    /**
     * @Then the user should be informed that their ip is banned
     */
    public function ThenTheUserShouldBeInformedThatTheirIpIsBanned()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Banned Users
    //========================================
    /**
     * @Then the user should be informed that they are banned
     */
    public function ThenTheUserShouldBeInformedThatTheyAreBanned()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not be logged in
     */
    public function ThenTheUserShouldNotBeLoggedIn()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not be able to submit a comment
     */
    public function ThenTheUserShouldNotBeAbleToSubmitAComment()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Activity Feed
    //========================================
    /**
     * @Then the user should see the latest activities of that user
     */
    public function ThenTheUserShouldSeeTheLatestActivitiesOfThatUser()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see the latest activities of users
     */
    public function ThenTheUserShouldSeeTheLatestActivitiesOfUsers()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @hen the activity should appear on the activity feed
     */
    public function ThenTheActivityShouldAppearOnTheActivityFeed()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see the old activity feed updates disappear
     */
    public function ThenTheUserShouldSeeTheOldActivityFeedUpdatesDisappear()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see the new activity feed updates at the top
     */
    public function ThenTheUserShouldSeeTheNewActivityFeedUpdatesAtTheTop()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Contact Form
    //=======================================
    /**
     * @Then the user should see a link to contact customer support
     */
    public function ThenTheUserShouldSeeALinkToContactCustomerSupport()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the message is sent
     */
    public function ThenTheUserShouldBeInformedThatTheMessageIsSent()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to fill out the required fields
     */
    public function ThenTheUserShouldBePromptedToFillOutTheRequiredFields()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a comment
     */
    public function ThenTheUserShouldBePromptedToEnterAComment()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the username is invalid
     */
    public function ThenTheUserShouldBeInformedThatTheUsernameIsInvalid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed to wait before resubmitting the same message
     */
    public function ThenTheUserShouldBeInformedToWaitBeforeResubmittingTheSameMessage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see an empty contact form
     */
    public function ThenTheUserShouldSeeAnEmptyContactForm()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Deactivated Users
    //========================================
    /**
     * @Then the user should not be registered
     */
    public function ThenTheUserShouldNotBeRegistered()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that they are deactivated
     */
    public function ThenTheUserShouldBeInformedThatTheyAreDeactivated()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not be able to submit a game comment
     */
    public function ThenTheUserShouldNotBeAbleToSubmitAGameComment()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Email Verification
    //========================================
    /**
     * @Then the user should receive an email verification link
     */
    public function ThenTheUserShouldReceiveAnEmailVerificationLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the email is already verified
     */
    public function ThenTheUserShouldBeInformedThatTheEmailIsAlreadyVerified()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the link has expired
     */
    public function ThenTheUserShouldBeInformedThatTheLinkHasExpired()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the link is invalid
     */
    public function ThenTheUserShouldBeInformedThatTheLinkIsInvalid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be able to resend the email verification link
     */
    public function ThenTheUserShouldBeAbleToResendTheEmailVerificationLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not see a link to resend email verification link
     */
    public function ThenTheUserShouldNotSeeALinkToResendEmailVerificationLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see if their email is already verified
     */
    public function ThenTheUserShouldSeeIfTheirEmailIsAlreadyVerified()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Favorite Games
    //========================================
    /**
     * @Then the user should see a list of games they have favorited
     */
    public function ThenTheUserShouldSeeAListOfGamesTheyHaveFavorited()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    /**
     * @Then the user should be able to manage their list of favorite games
     */
    public function ThenTheUserShouldBeAbleToManageTheirListOfFavoriteGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
        
    /**
     * @Then the user should see a list of favorite games of that user
     */
    public function ThenTheUserShouldSeeAListOfFavoriteGamesOfThatUser()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Favorite or Unfavorite Games
    //========================================
    /**
     * @Then the user should see a link to favorite a game
     */
    public function ThenTheUserShouldSeeALinkToFavoriteAGame()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see a link to unfavorite a game
     */
    public function ThenTheUserShouldSeeALinkToUnfavoriteAGame()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the system should mark the game as favorite
     */
    public function ThenTheSystemShouldMarkTheGameAsFavorite()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the system should not mark the game as favorite
     */
    public function ThenTheSystemShouldNotMarkTheGameAsFavorite()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Featured Games
    //========================================
    /**
     * @Then the user should see a slide of featured games
     */
    public function ThenTheUserShouldSeeASlideOfFeaturedGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
   /**
     * @Then the user should be taken to the game landing page
     */
    public function ThenTheUserShouldBeTakenToTheGameLandingPage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
   /**
     * @Then the slide should move to that featured game
     */
    public function ThenTheSlideShouldMoveToThatFeaturedGame()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
   /**
     * @Then the slide should loop back to the latest slide
     */
    public function ThenTheSliderShouldLoopBackToTheLatestSlide()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Game Category
    //========================================
    /**
     * @Then the user should see a page of games with that category
     */
    public function ThenTheUserShouldSeeAPageOfGamesWithThatCategory()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Game Comments
    //========================================
    /**
     * @Then the user should see a form to submit a game comment
     */
    public function ThenTheUserShouldSeeAFormToSubmitAGameComment()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see a link to login or register to post a comment
     */
    public function ThenTheUserShouldSeeALinkToLoginOrRegisterToPostAComment()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the comment should be saved
     */
    public function ThenTheCommentShouldBeSaved()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the comment should be displayed to the poster only
     */
    public function ThenTheCommentShouldBeDisplayedToThePosterOnly()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the comment should be labeled pending moderation
     */
    public function ThenTheCommentShouldBeLabeledPendingModeration()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to write a comment
     */
    public function ThenTheUserShouldBePromptedToWriteAComment()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the comment is invalid
     */
    public function ThenTheUserShouldBeInformedThatTheCommentIsInvalid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not be able to enter more than the maximum length
     */
    public function ThenTheUserShouldNotBeAbleToEnterMoreThanTheMaximumLength()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the submit comment button should disable itself for a few seconds
     */
    public function ThenTheSubmitCommentButtonShouldDisableItselfForAFewSeconds()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Game File
    //========================================
    /**
     * @Then the game swf should load 
     */
    public function ThenTheGameSwfShouldLoad()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Game Publisher
    //========================================
    /**
     * @Then the user should see a page of games by that publisher
     */
    public function ThenTheUserShouldSeeAPageOfGamesByThatPublisher()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Game Search
    //========================================
    /**
     * @Then the user should see a page containing relevant search results
     */
    public function ThenTheUserShouldSeeAPageContainingRelevantSearchResults()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    /**
     * @Then the user should be taken to the search results
     */
    public function ThenTheUserShouldBeTakenToTheSearchResults()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Game Submission
    //========================================
    /**
     * @Then the user should see a form to submit a game
     */
    public function ThenTheUserShouldSeeAFormToSubmitAGame()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the game is successfully submitted
     */
    public function ThenTheUserShouldBeInformedThatTheGameIsSuccessfullySubmitted()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the game submission form fields should be cleared
     */
    public function ThenTheGameSubmissionFormFieldsShouldBeCleared()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the form should validate if the file is the correct type
     */
    public function ThenTheFormShouldValidateIfTheFileIsTheCorrectType()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to upload a game with a valid file type
     */
    public function ThenTheUserShouldBePromptedToUploadAGameWithAValidFileType()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to upload an image with valid file type
     */
    public function ThenTheUserShouldBePromptedToUploadAnImageWithValidFileType()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the form should automatically resize the image
     */
    public function ThenTheFormShouldAutomaticallyResizeTheImage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the form should validate if the string is a valid email format
     */
    public function ThenTheFormShouldValidateIfTheStringIsAValidEmailFormat()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter an email with valid format
     */
    public function ThenTheUserShouldBePromptedToEnterAnEmailWithValidFormat()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a game name
     */
    public function ThenTheUserShouldBePromptedToEnterAGameName()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a description
     */
    public function ThenTheUserShouldBePromptedToEnterADescription()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a website link
     */
    public function ThenTheUserShouldBePromptedToEnterAWebsiteLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a developer
     */
    public function ThenTheUserShouldBePromptedToEnterADeveloper()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to select a game file
     */
    public function ThenTheUserShouldBePromptedToSelectAGameFile()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to select a thumbnail image
     */
    public function ThenTheUserShouldBePromptedToSelectAThumbnailImage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Game Tag
    //========================================
    /**
     * @Then the user should see a page of games with that tag
     */
    public function ThenTheUserShouldSeeAPageOfGamesWithThatTag()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Game Title
    //========================================
    /**
     * @Then the user should be able to view the game title
     */
    public function ThenTheUserShouldBeAbleToViewTheGameTitle()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Game Votes
    //========================================
    /**
     * @Then the user should see links to vote up or vote down the game
     */
    public function ThenTheUserShouldSeeLinksToVoteUpOrVoteDownTheGame()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be thanked for voting
     */
    public function ThenTheUserShouldBeThankedForVoting()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be able to change vote
     */
    public function ThenTheUserShouldBeAbleToChangeVote()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the game tally should refresh
     */
    public function ThenTheGameTallyShouldRefresh()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to login or register
     */
    public function ThenTheUserShouldBePromptedToLoginOrRegister()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should see if they already voted on a game
     */
    public function ThenTheUserShouldSeeIfTheyAlreadyVotedOnAGame()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Ip Logging
    //========================================
    /**
     * @Then the IP of the user should be recorded
     */
    public function ThenTheIpOfTheUserShouldBeRecorded()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Latest Games
    //========================================
    /**
     * @Then the user should see a list of latest games
     */
    public function ThenTheUserShouldSeeAListOfLatestGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Login
    //========================================
    /**
     * @Then the user should see a link to login
     */
    public function ThenTheUserShouldSeeALinkToLogin()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not see a link to login
     */
    public function ThenTheUserShouldNotSeeALinkToLogin()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be taken to the welcome page
     */
    public function ThenTheUserShouldBeTakenToTheWelcomePage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a username and password
     */
    public function ThenTheUserShouldBePromptedToEnterAUsernameAndPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that they entered an invalid username and password combo
     */
    public function ThenTheUserShouldBeInformedThatTheyEnteredAnInvalidUsernameAndPasswordCombo()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a username
     */
    public function ThenTheUserShouldBePromptedToEnterAUsername()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter a password
     */
    public function ThenTheUserShouldBePromptedToEnterAPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Login of Users Under 13 Years Old
    //========================================
    /**
     * @Then the user should be informed that their account needs to be confirmed by their parent
     */
    public function ThenTheUserShouldBeInformedThatTheirAccountNeedsToBeConfirmedByTheirParent()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Logout
    //========================================
    /**
     * @Then the user should see a link to logout 
     */
    public function ThenTheUserShouldSeeALinkToLogout()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be logged out from the site
     */
    public function ThenTheUserShouldBeLoggedOutFromTheSite()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be taken to the home page
     */
    public function ThenTheUserShouldBeTakenToTheHomePage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be taken to the login page
     */
    public function ThenTheUserShouldBeTakenToTheLoginPage()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // More Games
    //========================================
    /**
     * @Then the user should see a list of similar games
     */
    public function ThenTheUserShouldSeeAListOfSimilarGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Password Change
    //========================================
    /**
     * @ Then the user should be able to see a link to change password
     */
    public function ThenTheUserShouldBeAbleToSeeALinkToChangePassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the new password should be saved
     */
    public function ThenTheNewPasswordShouldBeSaved()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the user should be informed that the new password is saved
     */
    public function ThenTheUserShouldBeInformedThatTheNewPasswordIsSaved()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the form should disappear
     */
    public function ThenTheFormShouldDisappear()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the user should be prompted to fill out the blank fields
     */
    public function ThenTheUserShouldBePromptedToFillOutTheBlankFields()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the user should be prompted to enter their current password
     */
    public function ThenTheUserShouldBePromptedToEnterTheirCurrentPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the user should be prompted to enter a new password
     */
    public function ThenTheUserShouldBePromptedToEnterANewPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the user should be prompted to confirm new password
     */
    public function ThenTheUserShouldBePromptedToConfirmNewPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @ Then the user should be informed that the passwords do not match
     */
    public function ThenTheUserShouldBeInformedThatThePasswordsDoNotMatch()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // New Game Tag
    //========================================
    /**
     * @Then the user should see a corner label on the thumbnails of new games
     */
    public function ThenTheUserShouldSeeACornerLabelOnTheThumbnailsOfNewGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not see a corner label on the thumbnails of old games 
     */
    public function ThenTheUserShouldNotSeeACornerLabelOnTheThumbnailsOfOldGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Pagination
    //========================================
    
    
    //========================================
    // Password Reset
    //========================================
    /**
     * @Then the user should receive an email containing a password reset link 
     */
    public function ThenTheUserShouldReceiveAnEmailContainingAPasswordResetLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to enter an email
     */
    public function ThenTheUserShouldBePromptedToEnterAnEmail()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the username or email is not found
     */
    public function ThenTheUserShouldBeInformedThatTheUsernameOrEmailIsNotFound()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be able to submit new password
     */
    public function ThenTheUserShouldBeAbleToSubmitNewPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be able to login with the new password
     */
    public function ThenTheUserShouldBeAbleToLoginWithTheNewPassword()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the link is no longer valid
     */
    public function ThenTheUserShouldBeInformedThatTheLinkIsNoLongerValid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the password is invalid
     */
    public function ThenTheUserShouldBeInformedThatThePasswordIsInvalid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Popular Games
    //========================================
    /**
     * @Then the user should see a list of popular games
     */
    public function ThenTheUserShouldSeeAListOfPopularGames()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Recently Played Games
    //========================================
    /**
     * @Then the user should see a list of games they recently played
     */
    public function ThenTheUserShouldSeeAListOfGamesTheyRecentlyPlayed()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Registration
    //========================================
    /**
     * @Then the user should see a link to register
     */
    public function ThenTheUserShouldSeeALinkToRegister()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not see a link to register
     */
    public function ThenTheUserShouldNotSeeALinkToRegister()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be registered
     */
    public function ThenTheUserShouldBeRegistered()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be opt in to receive email updates
     */
    public function ThenTheUserShouldBeOptInToReceiveEmailUpdates()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the username is already taken
     */
    public function ThenTheUserShouldBeInformedThatTheUsernameIsAlreadyTaken()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the email is already registered
     */
    public function ThenTheUserShouldBeInformedThatTheEmailIsAlreadyRegistered()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    /**
     * @Then the user should be informed that the email is invalid
     */
    public function ThenTheUserShouldBeInformedThatTheEmailIsInvalid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to confirm the email
     */
    public function ThenTheUserShouldBePromptedToConfirmTheEmail()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the emails do not match
     */
    public function ThenTheUserShouldBeInformedThatTheEmailsDoNotMatch()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the captcha code is incorrect
     */
    public function ThenTheUserShouldBeInformedThatTheCaptchaCodeIsIncorrect()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be prompted to agree to the terms
     */
    public function ThenTheUserShouldBePromptedToAgreeToTheTerms()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Registration of Users Under 13 Years Old
    //========================================
    /**
     * @Then the user should be asked to provide their name and the email address of their parent
     */
    public function ThenTheUserShouldBeAskedToProvideTheirNameAndTheEmailAddressOfTheirParent()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not be able to create an account
     */
    public function ThenTheUserShouldNotBeAbleToCreateAnAccount()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @The the user should receive an email verification link
     */
    public function TheTheUserShouldReceiveAnEmailVerificationLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be verified
     */
    public function ThenTheUserShouldBeVerified()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the parent should receive an email containing a confirmation link
     */
    public function ThenTheParentShouldReceiveAnEmailContainingAConfirmationLink()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be confirmed
     */
    public function ThenTheUserShouldBeConfirmed()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not be confirmed
     */
    public function ThenTheUserShouldNotBeConfirmed()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the parent should be informed that the link is invalid
     */
    public function ThenTheParentShouldBeInformedThatTheLinkIsInvalid()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Remember Me Function
    //========================================
    /**
     * @Then the user should remain logged in for a period of time or until user logs out
     */
    public function ThenTheUserShouldRemainLoggedInForAPeriodOfTimeOrUntilUserLogsOut()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should remain logged out
     */
    public function ThenTheUserShouldRemainLoggedOut()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Slide Down Login Box
    //========================================
    /**
     * @Then a login box should slide down
     */
    public function ThenALoginBoxShouldSlideDown()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be logged in
     */
    public function ThenTheUserShouldBeLoggedIn()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Top Rated Game Tag
    //========================================
    /**
     * @Then the user should see a corner label on the swf marking the game as top rated
     */
    public function ThenTheUserShouldSeeACornerLabelOnTheSwfMarkingTheGameAsTopRated()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should not see a corner label on the swf marking the game as top rated
     */
    public function ThenTheUserShouldNotSeeACornerLabelOnTheSwfMarkingTheGameAsTopRated()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // User Avatar
    //========================================
    /**
     * @Then the user should be able to see a link to change avatar
     */
    public function ThenTheUserShouldBeAbleToSeeALinkToChangeAvatar()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the new avatar should be saved
     */
    public function ThenTheNewAvatarShouldBeSaved()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // User Info
    //========================================
    /**
     * @Then the user should see a thumbnail of their avatar and a welcome greeting in the header
     */
    public function ThenTheUserShouldSeeAThumbnailOfTheirAvatarAndAWelcomeGreetingInTheHeader()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // User Profile
    //========================================
    /**
     * @Then the user should see the profile page of that specific user
     */
    public function ThenTheUserShouldSeeTheProfilePageOfThatSpecificUser()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    
    //========================================
    // Username Recovery
    //========================================
    /**
     * @Then the user should receive an email containing their username
     */
    public function ThenTheUserShouldReceiveAnEmailContainingTheirUsername()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the user should be informed that the email is not found
     */
    public function ThenTheUserShouldBeInformedThatTheEmailIsNotFound()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    //========================================
    // Word Filter
    //========================================
    /**
     * @Then the inappropriate words should be substituted
     */
    public function ThenTheInappropriateWordsShouldBeSubstituted()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }

    /**
     * @Then the comment should be auto flagged
     */
    public function ThenTheCommentShouldBeAutoFlagged()
    {
        $this->markTestIncomplete("Step not yet implemented");
    }
    

}
