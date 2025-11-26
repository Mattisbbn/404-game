export default function getTextFromCategory(category) {
    switch (category) {
        case 'password':
            return 'Password Security';
        case 'phishing':
            return 'Phishing';
        case 'social_media':
            return 'Social Media';
        case 'cyber_risk':
            return 'Cyber Risk';
        default:
            return category;
    }
}
