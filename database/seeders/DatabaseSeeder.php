<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gameboard;
use Database\Factories\GameboardFactory;
use App\Models\Question;
use Database\Factories\QuestionFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach (GameboardFactory::boardEntries() as $entry) {
            Gameboard::factory()->create([
                'score' => $entry['score'],
                'position' => $entry['position'],
                'category' => $entry['category'],
            ]);
        }

        $questions = [
            // 🟦 CATEGORY 1 — PASSWORD SECURITY
            [
                'question' => 'Which password is the most resistant to brute-force attacks?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Paris2024!Update', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'SuperSecure!!22', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'T#9dLq3Ks8!rP2', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which method maximizes password entropy?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Combining two rare words', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Using a high-quality random generator', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'Replacing letters with numbers', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which password is least vulnerable if its hash is stolen?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'A password containing three symbols', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'A recently renewed password', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'A long, complex, non-derivable password', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which type of password resists AI prediction best?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'A pseudo-random sequence without human logic', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'A password based on hobbies', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'A long phrase with an invented word', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why can multiple random words be secure?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Dictionaries ignore these combinations', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Systems detect them as legitimate', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Their cumulative entropy is extremely high', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which behavior increases the risk of targeted attacks?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Adding a special character', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Using at least 10 characters', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Reusing a pattern like animal + year', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'What is the main benefit of a password manager?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'It synchronizes the same key everywhere', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'It generates passwords unrelated to human habits', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'It stores simple passwords encrypted', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which method resists AI trained on billions of passwords?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'A familiar expression modified', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'A rare word + date', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'A fully random password', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which configuration makes hash cracking extremely hard?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'A password with two symbols', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'A password changed regularly', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'A long, unpredictable password', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which password best resists Markov chains?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Sunset!369', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'W!7pT9b#4LfQ2s', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'InfoTech2024!', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why is “Violette2024!” weak?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'It contains a symbol', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'It\'s longer than 10 characters', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'It follows a predictable pattern', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which password is least likely to appear in leaks?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'P@ssword123!', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'rP9!sx2L#fQeD4', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'Azerty2024!', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why is leet-speak not effective?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'It\'s unreadable for systems', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'It breaks autofill', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Modern attacks test these substitutions', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which password has the highest entropy?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'U3#fL2!k9Zb8Qx', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'UpdatePC2024!!', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'BonjourToutLeMonde!', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'How to prevent password spraying?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Use a long, unpredictable password', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Add your birthdate', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Use a famous quote', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which behavior is riskier?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Using a password manager', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Avoiding public computers', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Reusing the same base and changing the ending', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which password resists linguistic predictions best?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'PetitChien$23', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'x!6Qf9Bt#2LmP4', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'DragonRouge2024!', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why can a passphrase still be weak?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'Words may be too predictable', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'It\'s too long', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'It contains punctuation', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which avoids human patterns the most?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'MyFavoriteFood99!', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'F!3qLb9T#p2ZrM', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'GuitarFan2024!', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why generate passwords automatically?',
                'points' => 1,
                'category' => 'password',
                'answers' => [
                    ['answer' => 'They follow no human logic', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'They are shorter', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'They are easier to remember', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],

            // 🟥 CATEGORY 2 — PHISHING
            [
                'question' => 'What is the clearest sign of advanced phishing?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'An empty attachment', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'A link redirecting to a very similar domain', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'An outdated logo', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Safest reaction to unexpected email?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Respond to confirm authenticity', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Open in private mode', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Hover the link to check the URL', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which phishing uses strong social engineering?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Real package tracking', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Newsletter', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Spear-phishing', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Slightly modified coworker email indicates…',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Simple typo', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Domain update', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Targeted spoofing', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'What usually makes phishing believable?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Use of personal information', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Formal tone', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'No spelling mistakes', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'How to react to a suspicious bank SMS?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Reply STOP', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Click to verify', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Contact the bank through official channels', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'What often reveals a fake webpage?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'HTTPS is valid', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'The design is similar', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'The domain doesn’t exactly match', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Clone phishing means…',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Sending to many targets', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Using fake social profiles', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Copying a real email & replacing links', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Urgent reset request usually means…',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'A phishing attempt', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'A system error', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Internal test', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why are ZIP files dangerous?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Slow to open', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Rarely expire', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'May contain disguised executables', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => '“Vishing” refers to…',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Fraudulent phone call', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'SMS phishing', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Fake video', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Main risk of phishing?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Slower computer', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Lost emails', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Credential theft', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Best reflex against phishing?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Check the domain in the address bar', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Turn off Wi-Fi', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Reset password', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why can a perfect email still be phishing?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Advanced attacks are well written', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'It means it’s official', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Hackers don’t use AI', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Smishing targets…',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'SMS', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Calls', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Social networks', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Pharming does what?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Redirects to fake site even with correct URL', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Creates fake profiles', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Sends mass emails', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which link is most suspicious?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'https://ma-banque.fr', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'https://service-client-secure.com.banking.fr/reset', 'letter' => 'B', 'isCorrect' => true],
                    ['answer' => 'https://secure.google.com', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Fraudulent meeting invite example?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Fake Microsoft Teams meeting', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Internal reminder', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Calendar share', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Safest reaction if unsure?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'Type the URL manually', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Click for speed', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Use the SMS link', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why do attacks use HTTPS?',
                'points' => 1,
                'category' => 'phishing',
                'answers' => [
                    ['answer' => 'To appear legitimate', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Because it’s mandatory', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'To load faster', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],

            // 🟩 CATEGORY 3 — SOCIAL MEDIA PROTECTION
            [
                'question' => 'Which data is most valuable to attackers?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Public profile photo', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Number of followers', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Birthdate + city', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Why reduce public visibility?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'To reduce OSINT data collection', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'To load pages faster', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'To reduce likes', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Most important security setting?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Hide comments', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Use dark mode', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Enable 2FA', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which behavior is risky?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Accepting empty profiles', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Uploading your CV', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Never posting photos', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why avoid online quizzes?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'They slow apps', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'They modify settings', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'They collect answers used for security questions', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'What shows an account is compromised?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Messages sent without your action', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Losing followers', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Algorithm change', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which post is dangerous?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Exact vacation dates', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'A desk photo', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'A quote', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Fake account often tries to…',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Post neutral content', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Hide activity', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Gather info via conversation', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Why disable auto-location?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'It reduces photo quality', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'It consumes battery', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'It exposes sensitive routines', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'What indicates a fake profile?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Few interactions despite many followers', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Account created 5 years ago', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'High-quality photo', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Which setting greatly reduces OSINT?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Private friends list', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Using a pseudonym', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Posting less', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why avoid showing employer publicly?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'It helps targeted attacks', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'It reduces visibility', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'It blocks recruiters', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Most suspicious message?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => '“Is this you in this video?”', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => '“Congrats on your job!”', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => '“Are you free tomorrow?”', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Main risk of posting documents?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Sensitive info leakage', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Low engagement', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Compression issues', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Best security reflex?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Check active sessions', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Change profile picture', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Use a long username', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why avoid sharing technical work details?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'They help attackers target systems', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'They are too complex', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'They’re uninteresting', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'What increases identity theft risk?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Posting too many personal details', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Rarely replying', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Blurry photos', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why be careful with public comments?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'They may reveal info unintentionally', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'They can be deleted', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'They reduce engagement', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'How can hackers exploit your friends list?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => 'Create a credible fake profile', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Check your tastes', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Follow your content', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Best way to secure an account?',
                'points' => 1,
                'category' => 'social_media',
                'answers' => [
                    ['answer' => '2FA + unique passwords', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Posting less', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Making account private on weekends', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            // 🟪 CATEGORY 4 — ADVANCED CYBER-RISK
            [
                'question' => 'What indicates advanced malware?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Missing icons', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Slow system', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Strange network activity', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'What risk is associated with unknown USB drives?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Possible automatic execution of malware', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Mechanical damage', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Accidental formatting', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'First thing during ransomware?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Restart', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Pay quickly', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Disconnect from network', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which attack bypasses simple authentication?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'MFA bypass', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'DNS spoofing', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Forced defrag', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Login anomalies indicate…',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'A time zone change', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'A sync error', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'A compromise', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Zero-day means…',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Unknown vulnerability', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Emergency patch', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Code test', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'What increases targeted attack risk?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Using VPN', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Working offline', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Downloading unofficial tools', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Why antivirus misses malware?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Needs premium', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Databases too heavy', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Malware uses evasion', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'A machine shuts down abruptly several times. Which hypothesis?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'A rootkit or compromised driver', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Incorrect screen resolution', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Wrong keyboard configuration', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'What reduces exploit risk?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Using same Wi-Fi', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Avoiding attachments', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Updating regularly', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Attack targeting humans?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Bounce attack', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'AES brute force', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Social engineering', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Which action protects against keyloggers?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Using 2FA', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Having a password manager', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Changing keyboard', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Sign of a botnet?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Outbound traffic spikes', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Screen dimming', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Icon moved', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Multiple web redirects indicate…',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Site overload', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Browser update', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Malicious script', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'Behavior reducing local exploit risk?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Dark mode', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Changing wallpaper', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Installing only official sources', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'MITM aim is to…',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Intercept communication', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Delete files', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Create fake accounts', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'Why avoid public Wi-Fi?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Traffic can be captured', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'It’s slow', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Battery drain', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'What is a Trojan?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Malicious tool disguised as legitimate', 'letter' => 'A', 'isCorrect' => true],
                    ['answer' => 'Maintenance script', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Expired certificate', 'letter' => 'C', 'isCorrect' => false]
                ]
            ],
            [
                'question' => 'What reflex for an unknown compressed file that looks correct?',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Scan it and verify the source', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Rename it', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Extract it and scan its content', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
            [
                'question' => 'PC contacting unknown servers regularly means…',
                'points' => 3,
                'category' => 'cyber_risk',
                'answers' => [
                    ['answer' => 'Corrupted file', 'letter' => 'A', 'isCorrect' => false],
                    ['answer' => 'Automatic update', 'letter' => 'B', 'isCorrect' => false],
                    ['answer' => 'Backdoor', 'letter' => 'C', 'isCorrect' => true]
                ]
            ],
        ];

        // On utilise la Factory pour créer les entrées proprement,
        // même si on force les données. Cela garde la cohérence du seeder.
        foreach ($questions as $data) {
            Question::create($data);
        }
    }
}
