-- Database: room_rover

DROP DATABASE IF EXISTS room_rover;
CREATE DATABASE room_rover;
USE room_rover;

-- Users table to store user information
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Email VARCHAR(60) UNIQUE,
    PhoneNumber VARCHAR(15),
    Password VARCHAR(255),
    Bio TEXT,
    Country VARCHAR(150),
    UserType VARCHAR(10),
    LinkedIn VARCHAR(255),
    Instagram VARCHAR(255),
    ProfileImage VARCHAR(255), 
    DisabilityStatus BOOLEAN
);

-- Hostels table to store hostel information
CREATE TABLE Hostels (
    HostelID INT PRIMARY KEY AUTO_INCREMENT,
    HostelName VARCHAR(50) UNIQUE,
    Available BOOLEAN DEFAULT TRUE -- Added Available column

);

CREATE TABLE Rooms (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    HostelID INT,
    RoomNumber VARCHAR(10),
    Capacity INT,
    RoomImage VARCHAR(255),
    Available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (HostelID) REFERENCES Hostels(HostelID)
);

-- Slots table to manage the availability of each slot within a room
CREATE TABLE Slots (
    SlotID INT PRIMARY KEY AUTO_INCREMENT,
    RoomID INT,
    SlotNumber INT,
    IsAvailable BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
);

-- Bookings table to manage the assignment of users to specific slots in rooms
CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    RoomID INT,
    SlotID INT, -- Reference SlotID for individual slot booking
    BookingDate DATE,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID),
    FOREIGN KEY (SlotID) REFERENCES Slots(SlotID)
);

-- Pairings table to store potential room pairings and their compatibility scores
CREATE TABLE Pairings (
    PairingID INT PRIMARY KEY AUTO_INCREMENT,
    CompatibilityScore DECIMAL(5,2)
);

-- PairingMembers table to associate users with specific pairings
CREATE TABLE PairingMembers (
    PairingMemberID INT PRIMARY KEY AUTO_INCREMENT,
    PairingID INT,
    UserID INT,
    FOREIGN KEY (PairingID) REFERENCES Pairings(PairingID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Notifications table to store notifications for users
CREATE TABLE Notifications (
    NotificationID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    NotificationText TEXT,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Blacklist table to manage users who have been blacklisted
CREATE TABLE Blacklist (
    BlacklistID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Reason TEXT,
    DateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);


CREATE TABLE Requests (
    RequestID INT PRIMARY KEY AUTO_INCREMENT,
    SenderUserID INT,          
    ReceiverUserID INT,       
    RequestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    Accepted BOOLEAN DEFAULT FALSE,   
    FOREIGN KEY (SenderUserID) REFERENCES Users(UserID),
    FOREIGN KEY (ReceiverUserID) REFERENCES Users(UserID)
);

CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    FeedbackText TEXT,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Likes, Dislikes, and Knows tables to manage user preferences and knowledge
CREATE TABLE Likes (
    LikeID INT PRIMARY KEY AUTO_INCREMENT,
    LikeText VARCHAR(255)
);

CREATE TABLE Dislikes (
    DislikeID INT PRIMARY KEY AUTO_INCREMENT,
    DislikeText VARCHAR(255)
);

CREATE TABLE Knows (
    KnowID INT PRIMARY KEY AUTO_INCREMENT,
    KnowText VARCHAR(255)
);

-- UserLikes, UserDislikes, and UserKnows tables to associate preferences and knowledge with users
CREATE TABLE UserLikes (
    UserLikeID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    LikeID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (LikeID) REFERENCES Likes(LikeID)
);

CREATE TABLE UserDislikes (
    UserDislikeID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    DislikeID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (DislikeID) REFERENCES Dislikes(DislikeID)
);

CREATE TABLE UserKnows (
    UserKnowID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    KnowID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (KnowID) REFERENCES Knows(KnowID)
);


INSERT INTO Hostels (HostelName) VALUES
('Kofi Tawiah'),
('Wangari Mathai'),
('Walter Sisulu'),
('Ephraim-Amu'),
('Oteng Korankye'),
('Hostel 2C'),
('Hostel 2D');

-- Insert initial data into Rooms table
INSERT INTO Rooms (HostelID, RoomNumber, Capacity, RoomImage, Available) VALUES
(1, 'I-1', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-2', 2, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-3', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-4', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-5', 2, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-6', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-7', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-8', 2, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-9', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-10', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-11', 2, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-12', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-13', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-14', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-15', 2, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-16', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-17', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-18', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-19', 2, '../uploads/kofitawiah_hostel.jpg', TRUE),
(1, 'I-20', 4, '../uploads/kofitawiah_hostel.jpg', TRUE),

(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 2, '../uploads/wangari_hostel.jpg', TRUE),
(2, 'H-1', 4, '../uploads/wangari_hostel.jpg', TRUE),

(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 2, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 2, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 2, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 2, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 2, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 2, '../uploads/walter_hostel.jpeg', TRUE),
(3, 'J-1', 4, '../uploads/walter_hostel.jpeg', TRUE),

(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 4, '../uploads/ephramamum_host.jpg', TRUE),
(4, 'D-1', 2, '../uploads/ephramamum_host.jpg', TRUE),

(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 4, '../uploads/oteng_hostel.jpg', TRUE),
(5, 'F-1', 2, '../uploads/oteng_hostel.jpg', TRUE),

(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 4, '../uploads/hostel_2D', TRUE),
(6, 'L-1', 2, '../uploads/hostel_2D', TRUE),

(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 4, '../uploads/hostel_2D', TRUE),
(7, 'K-1', 2, '../uploads/hostel_2D', TRUE);

-- Insert initial data into Slots table
INSERT INTO Slots (RoomID, SlotNumber, IsAvailable) VALUES
(1, 1, TRUE),
(1, 2, TRUE),
(1, 3, TRUE),
(1, 4, TRUE),
(2, 1, TRUE),
(2, 2, TRUE),
(3, 1, TRUE),
(3, 2, TRUE),
(3, 3, TRUE),
(3, 4, TRUE),
(4, 1, TRUE),
(4, 2, TRUE),
(5, 1, TRUE),
(5, 2, TRUE),
(5, 3, TRUE),
(5, 4, TRUE),
(6, 1, TRUE),
(6, 2, TRUE),
(7, 1, TRUE),
(7, 2, TRUE),
(7, 3, TRUE),
(7, 4, TRUE);


-- Insert initial data into Likes table
INSERT INTO Likes (LikeText) VALUES
('Clean Room'),
('Organized Space'),
('Quiet Roommate'),
('Shared Chores'),
('Natural Light'),
('Personal Space'),
('Good Ventilation'),
('Minimalistic Decor'),
('Morning Person'),
('Evening Person');


-- Insert initial data into Dislikes table
INSERT INTO Dislikes (DislikeText) VALUES
('Messy Roommate'),
('Late-night Noise'),
('Overcrowded Space'),
('Strong Odors'),
('Cluttered Room'),
('Loud Music'),
('Noisy Neighbors'),
('Frequent Visitors'),
('Poor Ventilation'),
('Overuse of Shared Items');


-- Insert initial data into Knows table
INSERT INTO Knows (KnowText) VALUES
('Differently Abled'),
('First Year'),
('Second Year'),
('Third Year'),
('Fourth Year'),
('Early Bird'),
('Night Owl'),
('Needs Quiet'),
('Roommate Preferences'),
('Study Habits');
