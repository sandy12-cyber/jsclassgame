<?php

/**
 * SpeakUp! — Supplementary question bank (round 3 expansion).
 *
 * Each theme/level below adds 4 extra questions to the base deck,
 * taking every deck from 6 → 10 cards (480 questions total).
 *
 * Structure mirrors questions.php:
 *   [theme_slug => [level => [ [prompt, sample_answer, tips, vocabulary], ... ]]]
 *
 * Escaping rule: escape every apostrophe inside single-quoted strings
 * (e.g. don\'t). Use double quotes for strings containing a possessive
 * apostrophe at the end (e.g. "workers' rights").
 */

return [

    // ============================================================
    // 1. DAILY LIFE (extra)
    // ============================================================
    'daily-life' => [
        'A1' => [
            ['Do you drink coffee or tea?', 'I drink tea every morning. My mother drinks coffee. I do not like coffee.', 'Name your drink + one family member\'s drink.', ['coffee', 'tea', 'morning']],
            ['What do you do on Sunday?', 'On Sunday I rest at home. I watch TV and play with my brother. We eat lunch together.', 'Use "On Sunday I..." + 2 activities.', ['Sunday', 'rest', 'lunch', 'together']],
            ['Is your house big or small?', 'My house is small but nice. It has three rooms. I like my room.', 'Use "big" or "small" + one detail.', ['big', 'small', 'room', 'nice']],
            ['What time do you sleep?', 'I sleep at 10 o\'clock. My little sister sleeps at 8. I read before I sleep.', 'Say the time + one habit.', ['sleep', 'o\'clock', 'read']],
        ],
        'A2' => [
            ['How do you get to school or work?', 'I usually take the bus. It takes about twenty minutes. Sometimes my father drives me when it rains.', 'Mention transport + time + a condition.', ['take the bus', 'drive', 'minute', 'when it rains']],
            ['What is your morning routine?', 'I wake up, brush my teeth, and take a shower. Then I have breakfast and get dressed. I leave the house at seven.', 'Use sequence words: first, then, after that.', ['routine', 'brush my teeth', 'get dressed', 'shower']],
            ['Do you help at home?', 'Yes, I help my mother. I wash the dishes and clean my room. On weekends I help cook lunch.', 'Mention 2 chores + when.', ['help', 'wash the dishes', 'clean', 'cook']],
            ['What do you do before bed?', 'Before bed I brush my teeth and read a book for ten minutes. Then I turn off the light and sleep.', 'List 2–3 evening habits.', ['before bed', 'brush my teeth', 'read', 'turn off']],
        ],
        'B1' => [
            ['How do you stay productive during a busy day?', 'I break my day into focused blocks and take short breaks between them. I also avoid checking my phone while working, which makes a surprising difference.', 'Mention a technique + a habit to avoid.', ['productive', 'focused block', 'break', 'avoid']],
            ['What is something you would like to change about your routine?', 'I\'d like to wake up earlier to exercise. I often feel rushed in the morning, and starting the day with movement would make me feel more energised.', 'Use "I would like to" + a reason.', ['rush', 'energised', 'movement', 'morning']],
            ['Do you think people spend their free time well today? Why?', 'Not always. Many people scroll on their phones for hours, which feels relaxing but isn\'t very rewarding. I think we\'d benefit from more active hobbies.', 'Give an opinion + an example.', ['scroll', 'rewarding', 'hobby', 'benefit']],
            ['Describe a small daily pleasure you look forward to.', 'I look forward to my morning coffee. The smell, the warmth, the quiet five minutes before the day begins — it\'s a small ritual that sets a calm tone.', 'Use sensory detail.', ['look forward to', 'warmth', 'ritual', 'calm']],
        ],
        'B2' => [
            ['In what ways do daily micro-habits shape long-term outcomes?', 'I think micro-habits are quietly powerful because their effects compound. Reading ten pages a day becomes books a year, and a short daily walk adds up to real fitness. The danger is that the same compounding works against us with bad habits.', 'Use the concept of compounding.', ['micro-habit', 'compound', 'fitness', 'effect']],
            ['How do you distinguish between a healthy routine and a rut?', 'A healthy routine feels supportive and leaves room for variation, while a rut feels automatic and draining. The key sign for me is anticipation — if I dread the day, something needs to change.', 'Contrast two similar states.', ['rut', 'supportive', 'draining', 'anticipation']],
            ['Discuss the tension between structure and spontaneity in daily life.', 'I think they need each other. Pure structure becomes rigid and joyless, while pure spontaneity can feel chaotic and unproductive. The sweet spot is a flexible scaffold that frees attention for what matters.', 'Frame as a productive tension.', ['rigid', 'joyless', 'chaotic', 'scaffold']],
            ['How might remote work reshape the rhythm of family life?', 'Remote work blurs the boundary between professional and personal time, which can either enrich family life or erode it. Families that set clear rituals — shared meals, device-free hours — tend to benefit most.', 'Discuss both outcomes + a condition.', ['blur', 'erode', 'ritual', 'device-free']],
        ],
    ],

    // ============================================================
    // 2. TRAVEL & ADVENTURE (extra)
    // ============================================================
    'travel-adventure' => [
        'A1' => [
            ['Do you like flying?', 'Yes, I like flying. I look out the window. The clouds are beautiful. But my ears hurt a little.', 'Say yes/no + one feeling.', ['fly', 'window', 'cloud', 'ear']],
            ['Where did you go last year?', 'Last year I went to the beach with my family. We swam and ate seafood. I took many photos.', 'Use past tense: went, swam, ate.', ['last year', 'beach', 'seafood', 'photo']],
            ['Do you have a passport?', 'Yes, I have a passport. It is blue. I use it when I fly to other countries.', 'Describe your passport + when you use it.', ['passport', 'blue', 'fly', 'country']],
            ['What do you do on a long trip?', 'On a long trip I sleep and read. I also play games on my phone. The time goes fast.', 'List 2–3 activities during travel.', ['long trip', 'sleep', 'read', 'game']],
        ],
        'A2' => [
            ['What do you always pack when you travel?', 'I always pack my phone charger, comfortable shoes, and a jacket. I also bring a book for the journey. It helps me pass the time.', 'List 3 essentials + why.', ['pack', 'charger', 'comfortable', 'journey']],
            ['Have you ever travelled by train?', 'Yes, I took a train to another city last year. The view was beautiful and the seats were comfortable. It was cheaper than flying.', 'Use past tense + describe it.', ['train', 'view', 'seat', 'cheap']],
            ['What is the best souvenir you have brought home?', 'The best souvenir I brought home was a small handmade bowl from Bali. I use it every day, and it reminds me of the trip.', 'Describe the souvenir + its meaning.', ['souvenir', 'handmade', 'bowl', 'remind']],
            ['Do you like trying local food when you travel?', 'Yes, I love trying local food. It is part of the adventure. Sometimes the food is strange, but I always try it once.', 'Express enthusiasm + a condition.', ['local food', 'adventure', 'strange', 'try']],
        ],
        'B1' => [
            ['How do you plan a trip to make the most of a short time?', 'I research the must-see spots but leave half my schedule open. Trying to fit too much in makes a trip feel like a checklist. The best moments often come from unplanned detours.', 'Argue for balance.', ['must-see', 'checklist', 'detour', 'unplanned']],
            ['Describe a travel experience that didn\'t go as expected.', 'I once booked a "beachfront" hotel that turned out to be nowhere near the sea. At first I was furious, but the owner was so kind and the local food so good that it became my favourite trip.', 'Use narrative + a turn.', ['beachfront', 'furious', 'owner', 'favourite']],
            ['Do you think travel apps have made travel better or worse?', 'Better in many ways — booking is instant and reviews save us from bad choices. But they\'ve also made travel feel generic, with everyone following the same top-ten lists. Serendipity has declined.', 'Weigh pros and cons.', ['instant', 'review', 'generic', 'serendipity']],
            ['How do you handle language barriers when travelling?', 'I learn a few key phrases, use a translation app, and rely on gestures and smiles. Most people appreciate the effort, and the awkward moments often become funny stories.', 'List strategies + the human element.', ['phrase', 'translation app', 'gesture', 'effort']],
        ],
        'B2' => [
            ['"We travel not to escape life, but for life not to escape us." Discuss.', 'I find this resonant. Travel jolts us out of autopilot and forces us to actually notice our days, which is the opposite of escape. The irony is that by leaving, we often return more present.', 'Interpret the quotation philosophically.', ['resonant', 'autopilot', 'irony', 'present']],
            ['How can travellers minimise their environmental footprint without giving up travel?', 'I think it\'s about choices: train over plane where possible, longer stays instead of many short flights, and supporting local businesses rather than international chains. Carbon offsets help but shouldn\'t be an excuse to overfly.', 'Propose concrete trade-offs.', ['footprint', 'offset', 'chain', 'excuse']],
            ['Discuss whether tourism can ever truly benefit local communities.', 'It can, but only when designed to. Mass tourism often extracts wealth and culture, while community-led tourism keeps money local and respects traditions. The model matters more than the volume.', 'Distinguish models of tourism.', ['extract', 'community-led', 'tradition', 'volume']],
            ['How might the concept of "slow travel" change how we see the world?', 'Slow travel — staying longer, going deeper — shifts the goal from collecting places to understanding them. I think it fosters humility, because you stop being a passing observer and start participating in daily life.', 'Reflect on a travel philosophy.', ['slow travel', 'humility', 'observer', 'participate']],
        ],
    ],

    // ============================================================
    // 3. FOOD & COOKING (extra)
    // ============================================================
    'food-cooking' => [
        'A1' => [
            ['Do you like fruit?', 'Yes, I like fruit. I eat apples and bananas. My sister likes grapes.', 'Name 2 fruits you like.', ['fruit', 'apple', 'banana', 'grape']],
            ['What do you drink with lunch?', 'I drink water with lunch. My father drinks tea. Sometimes I have juice.', 'Name your drink + someone else\'s.', ['water', 'tea', 'juice', 'lunch']],
            ['Can you make a sandwich?', 'Yes, I can make a sandwich. I put bread, cheese, and tomato. It is easy.', 'List the ingredients you use.', ['sandwich', 'bread', 'cheese', 'tomato']],
            ['Do you like spicy food?', 'Yes, I like spicy food. I eat chilli with my noodles. My mother makes spicy soup.', 'Say yes/no + one example.', ['spicy', 'chilli', 'noodle', 'soup']],
        ],
        'A2' => [
            ['What food from your country would you recommend to a visitor?', 'I would recommend satay — grilled meat on sticks with peanut sauce. It is tasty and easy to eat. You can find it everywhere.', 'Describe the dish + why recommend it.', ['recommend', 'satay', 'peanut sauce', 'tasty']],
            ['Do you prefer eating at home or eating out?', 'I prefer eating at home because it is cheaper and healthier. But on special days I enjoy eating out with friends.', 'State preference + 2 reasons.', ['prefer', 'cheaper', 'healthier', 'special']],
            ['Talk about a food you do not like.', 'I do not like bitter gourd. It is very bitter, even with spices. My mother says it is healthy, but I cannot eat it.', 'Describe the food + why.', ['bitter gourd', 'bitter', 'spice', 'healthy']],
            ['What is a dish you would like to learn to cook?', 'I would like to learn to make pasta from scratch. It looks fun to roll the dough. My friend can teach me.', 'Use "I would like to" + why.', ['pasta', 'dough', 'roll', 'teach']],
        ],
        'B1' => [
            ['How important is presentation in the food you eat?', 'More than I used to think. A dish that looks beautiful feels more satisfying, even if the taste is the same. I think we eat with our eyes first, which is why plating matters in good restaurants.', 'Argue for the importance of looks.', ['presentation', 'satisfying', 'plating', 'restaurant']],
            ['Describe a meal that reminds you of home.', 'My grandmother\'s chicken soup reminds me of home. The smell fills the whole house, and the recipe has been in our family for generations. Whenever I\'m unwell, it\'s the only thing I want.', 'Use sensory + emotional detail.', ['remind', 'smell', 'recipe', 'generation']],
            ['Do you think diets reflect a person\'s values?', 'Increasingly, yes. Choosing local, organic, or plant-based food often signals concern for sustainability or animal welfare. What we eat has become a small daily statement of what we value.', 'Connect diet to values.', ['organic', 'plant-based', 'sustainability', 'welfare']],
            ['How has convenience changed the way people eat?', 'Convenience has made food faster but less deliberate. Ready meals and delivery mean many people rarely cook, which I think is a loss. Cooking teaches patience and brings people together.', 'Reflect on a trade-off.', ['convenience', 'ready meal', 'delivery', 'deliberate']],
        ],
        'B2' => [
            ['"Tell me what you eat, and I will tell you what you are." Discuss.', 'I think this holds more truth than it first appears. Our food choices reveal class, culture, health awareness, and even ethics. A single meal can tell a complex social story if you know how to read it.', 'Interpret the quotation analytically.', ['class', 'culture', 'ethics', 'read']],
            ['How should societies address food waste?', 'It needs action at every level. Supermarkets could relax cosmetic standards, restaurants could donate surplus, and households could plan meals better. The infrastructure exists; what\'s missing is coordination and will.', 'Propose multi-level solutions.', ['cosmetic standard', 'surplus', 'donate', 'coordination']],
            ['Discuss the cultural significance of communal eating.', 'Communal eating is one of the oldest social rituals — it signals trust, equality, and shared identity. When it declines, I think something important is lost, because breaking bread together builds bonds that meetings cannot.', 'Frame as a social ritual.', ['communal', 'ritual', 'identity', 'break bread']],
            ['How might lab-grown meat change our relationship with food?', 'Lab-grown meat could decouple meat from animal suffering, which would be transformative ethically. But it also risks further distancing us from where food comes from. I suspect it will complement rather than replace traditional farming for a long time.', 'Speculate on ethical and cultural effects.', ['lab-grown', 'decouple', 'suffering', 'distance']],
        ],
    ],

    // ============================================================
    // 4. FAMILY & FRIENDS (extra)
    // ============================================================
    'family-friends' => [
        'A1' => [
            ['Do you have a pet?', 'Yes, I have a cat. Her name is Mimi. She is white and small.', 'Describe your pet + its name.', ['pet', 'cat', 'name', 'small']],
            ['Who do you live with?', 'I live with my mother and father. I have one brother. We live in a small house.', 'List who you live with.', ['live with', 'mother', 'father', 'brother']],
            ['Do you play with your friends?', 'Yes, I play with my friends at school. We play football. We laugh a lot.', 'Say yes/no + what you play.', ['play', 'friend', 'football', 'laugh']],
            ['What does your mother do?', 'My mother is a nurse. She works at the hospital. She helps sick people.', 'Say her job + where.', ['nurse', 'hospital', 'help', 'sick']],
        ],
        'A2' => [
            ['How are you similar to or different from your siblings?', 'I am quiet but my brother is very talkative. We both love football, though. We are different but we get along well.', 'Use "but" and "both" to compare.', ['similar', 'different', 'talkative', 'get along']],
            ['Describe a favourite memory with a family member.', 'My favourite memory is fishing with my grandfather. We woke up very early and sat by the river. He taught me how to be patient.', 'Use past tense + a feeling.', ['memory', 'fishing', 'grandfather', 'patient']],
            ['What do you and your friends usually talk about?', 'We talk about school, films, and our plans for the weekend. Sometimes we talk about our problems. We trust each other.', 'Mention 2–3 topics.', ['talk about', 'film', 'weekend', 'trust']],
            ['How do you celebrate birthdays in your family?', 'We have a big dinner with cake. My mother cooks my favourite food. We sing and take photos together.', 'Describe the celebration + activities.', ['celebrate', 'birthday', 'cake', 'sing']],
        ],
        'B1' => [
            ['How do you maintain long-distance friendships?', 'I schedule regular video calls and send voice notes instead of just texting. Visiting once a year keeps the bond strong. It takes effort, but true friends are worth it.', 'Mention methods + a principle.', ['long-distance', 'video call', 'voice note', 'effort']],
            ['In what ways has your family shaped who you are?', 'My family taught me the value of hard work and kindness. Watching my parents sacrifice for our education shaped my own ambitions. I carry their values even when I disagree with them.', 'Connect family to personal values.', ['sacrifice', 'ambition', 'value', 'shape']],
            ['Do you think it\'s harder to make friends as an adult? Why?', 'Yes, I think so. As children we make friends through proximity, but as adults we need shared interests and deliberate effort. Work and family leave less time, so friendships require more intention.', 'Explain a shift with reasons.', ['proximity', 'shared interest', 'deliberate', 'intention']],
            ['Describe a disagreement you had with a friend and how you resolved it.', 'A friend and I argued about money we had shared. We both felt misunderstood, but we eventually talked honestly without blaming each other. The friendship became stronger afterwards.', 'Use narrative + resolution.', ['disagreement', 'misunderstood', 'blame', 'resolve']],
        ],
        'B2' => [
            ['How do family expectations shape individual choices?', 'Family expectations can be both a compass and a cage. They provide guidance and continuity, but they can also constrain choices around career, marriage, and identity. Navigating them is one of the central tasks of adulthood.', 'Frame as a dual force.', ['compass', 'cage', 'constrain', 'navigate']],
            ['Discuss whether friendships or family bonds are more durable.', 'I think family bonds are more durable by default because they don\'t depend on choice, but friendships can be more deliberately chosen and therefore more aligned with who we become. Durability and depth aren\'t the same thing.', 'Distinguish durability from depth.', ['durable', 'default', 'aligned', 'depth']],
            ['How might changing social structures affect the family of the future?', 'I expect families to become more diverse — chosen families, co-parenting arrangements, multigenerational households. The nuclear model may become one option among many. What matters is whether bonds of care remain strong.', 'Speculate with conditions.', ['chosen family', 'co-parenting', 'multigenerational', 'nuclear']],
            ['Reflect on a friendship that ended and what it taught you.', 'A close friendship ended when we grew in different directions. At first I felt I had failed, but I learned that some friendships have a natural season. Letting go gracefully is itself a skill, and the loss made room for new bonds.', 'Use reflective tone.', ['grow apart', 'season', 'let go', 'gracefully']],
        ],
    ],

    // ============================================================
    // 5. WORK & CAREER (extra)
    // ============================================================
    'work-career' => [
        'A1' => [
            ['Do you want to work in an office?', 'Yes, I want to work in an office. It is clean and cool. But I also want to meet people.', 'Say yes/no + one reason.', ['office', 'clean', 'cool', 'meet']],
            ['What does your mother do?', 'My mother is a teacher. She works at a school. She teaches English.', 'Say her job + subject.', ['teacher', 'school', 'teach', 'English']],
            ['Do you like computers?', 'Yes, I like computers. I play games and draw. I want to learn to code.', 'Say yes/no + 2 things you do.', ['computer', 'game', 'draw', 'code']],
            ['What job is hard?', 'I think a firefighter\'s job is hard. It is dangerous and hot. They are very brave.', 'Name a hard job + why.', ['firefighter', 'dangerous', 'hot', 'brave']],
        ],
        'A2' => [
            ['What would you like to do after you finish school?', 'After school I would like to study engineering at university. I enjoy maths and problem-solving. I hope to design buildings one day.', 'Use "I would like to" + reasons.', ['after school', 'engineering', 'maths', 'design']],
            ['Do you think it is important to like your job?', 'Yes, I think it is very important. We spend many hours at work, so if we do not like it, we feel unhappy. But the job must also pay enough to live.', 'Give an opinion + a condition.', ['like', 'spend', 'unhappy', 'pay']],
            ['Talk about a skill you would like to learn for work.', 'I would like to learn public speaking. It is useful for many jobs, and it would make me more confident when I present my ideas.', 'Explain the skill + why useful.', ['public speaking', 'useful', 'confident', 'present']],
            ['Would you prefer to work indoors or outdoors?', 'I would prefer to work indoors because it is comfortable. But I would like a job that sometimes lets me go outside, so I am not always at a desk.', 'State preference + a nuance.', ['indoors', 'outdoors', 'comfortable', 'desk']],
        ],
        'B1' => [
            ['How do you handle pressure at work or school?', 'I break big tasks into smaller steps and focus on one at a time. I also remind myself that pressure is normal and that I\'ve handled difficult things before. Taking short breaks helps me stay calm.', 'Describe a coping strategy.', ['pressure', 'step', 'normal', 'calm']],
            ['Do you think internships are valuable?', 'Very valuable. They give you real experience that textbooks can\'t, and they help you test whether a career actually suits you. I learned more in three months of internship than in a year of lectures.', 'Argue with a personal example.', ['internship', 'experience', 'textbook', 'suit']],
            ['What would make a workplace ideal for you?', 'An ideal workplace would have supportive colleagues, clear expectations, and room to grow. I value flexibility and trust over fancy perks. A healthy culture matters more than salary alone.', 'List qualities + a priority.', ['supportive', 'expectation', 'flexibility', 'culture']],
            ['Describe a time you had to learn something quickly for work or school.', 'I had to learn a new software tool two days before a presentation. I focused on the essentials, watched tutorials, and asked a colleague for help. It was stressful but I managed.', 'Use narrative + outcome.', ['software', 'tutorial', 'colleague', 'stressful']],
        ],
        'B2' => [
            ['"Find a job you love and you\'ll never work a day in your life." Discuss.', 'I find this misleading. Even loved work is still work — it has frustrations, fatigue, and bad days. The saying obscures the real goal, which is finding work whose difficulties feel meaningful to you.', 'Critique the popular saying.', ['misleading', 'frustration', 'fatigue', 'meaningful']],
            ['How should companies balance productivity with employee well-being?', 'I think the two aren\'t actually opposed in the long run. Burned-out employees produce lower-quality work, so well-being is an investment. The healthiest companies measure outcomes, not hours, and protect recovery time.', 'Argue that they reinforce each other.', ['opposed', 'burned-out', 'outcome', 'recovery']],
            ['Discuss whether loyalty to one employer is still realistic.', 'Loyalty in both directions has declined, and I think that\'s largely because the old implicit contract — stay and we\'ll take care of you — broke down. Frequent job changes are now a rational response, though they have costs too.', 'Frame as a structural change.', ['loyalty', 'implicit', 'rational', 'contract']],
            ['How might the gig economy reshape career trajectories?', 'The gig economy offers flexibility but fragments careers into short engagements, which can make deep expertise harder to build. I suspect we\'ll see hybrid paths — a stable core plus gig projects — rather than wholesale replacement of traditional employment.', 'Speculate on hybrid futures.', ['gig economy', 'fragment', 'expertise', 'hybrid']],
        ],
    ],

    // ============================================================
    // 6. HOBBIES & INTERESTS (extra)
    // ============================================================
    'hobbies-interests' => [
        'A1' => [
            ['Do you like singing?', 'Yes, I like singing. I sing in the shower. My friend sings very well.', 'Say yes/no + when/where.', ['sing', 'shower', 'friend', 'well']],
            ['What do you do on Sunday?', 'On Sunday I play with my toys. I also draw pictures. I rest a lot.', 'List 2 Sunday activities.', ['Sunday', 'toy', 'draw', 'rest']],
            ['Can you swim?', 'Yes, I can swim a little. I swim in the pool. My father teaches me.', 'Say yes/no + where.', ['swim', 'pool', 'father', 'teach']],
            ['Do you have a hobby?', 'Yes, my hobby is collecting stickers. I have many stickers in a book. They are colourful.', 'Name your hobby + describe it.', ['hobby', 'collect', 'sticker', 'colourful']],
        ],
        'A2' => [
            ['How did you start your favourite hobby?', 'I started painting when I was ten. My aunt gave me watercolours for my birthday. I loved it immediately and have painted ever since.', 'Use past tense + how it began.', ['start', 'watercolour', 'aunt', 'immediately']],
            ['Do you prefer active or relaxing hobbies?', 'I prefer relaxing hobbies like reading and knitting. They help me calm down after a busy day. But I also walk for exercise.', 'State preference + why.', ['active', 'relaxing', 'knitting', 'calm down']],
            ['Talk about a hobby you would like to try.', 'I would like to try rock climbing. It looks exciting and it is good exercise. I need to find a class first.', 'Use "I would like to try" + why.', ['rock climbing', 'exciting', 'exercise', 'class']],
            ['Is it better to have one hobby or many?', 'I think it is better to have a few hobbies. One hobby can become boring, but too many means you do not get good at any. Two or three is a good balance.', 'Express a balanced view.', ['boring', 'good at', 'balance', 'a few']],
        ],
        'B1' => [
            ['How do hobbies contribute to your identity?', 'Hobbies shape how I see myself and how others see me. Being "the one who paints" or "the runner" gives me a sense of self beyond work. They\'re a quiet form of self-definition.', 'Connect hobby to identity.', ['identity', 'self', 'beyond work', 'definition']],
            ['Have you ever turned a hobby into something serious?', 'I turned my love of photography into a small side business. It changed how I saw it — suddenly there were clients and deadlines. I learned that passion and profession require different mindsets.', 'Use narrative + reflection.', ['side business', 'client', 'deadline', 'mindset']],
            ['Do hobbies need to be productive?', 'Not at all. I think the best hobbies are pointless in the best sense — done for joy, not output. The pressure to monetise every interest can drain the very pleasure that made it special.', 'Argue against instrumentalising hobbies.', ['productive', 'pointless', 'monetise', 'drain']],
            ['How do hobbies help you connect with others?', 'Hobbies create instant communities. Joining a running club or a knitting group introduces you to people you\'d never otherwise meet, united by a shared passion. The activity becomes a bridge.', 'Explain the social function.', ['community', 'club', 'passion', 'bridge']],
        ],
        'B2' => [
            ['"Hobbies are the best antidote to burnout." Discuss.', 'I largely agree, with a caveat. Hobbies that absorb us fully offer genuine recovery in a way passive leisure doesn\'t. The caveat is that hobbies turned into side hustles lose this restorative power, becoming more work.', 'Engage with nuance.', ['antidote', 'absorb', 'recovery', 'restorative']],
            ['How has the internet changed hobby culture?', 'It has democratised expertise — anyone can learn almost anything — but it has also turned hobbies into performance. The pressure to share and compare can crowd out the quiet joy that makes hobbies restorative in the first place.', 'Weigh democratisation against performativity.', ['democratise', 'performance', 'compare', 'crowd out']],
            ['Discuss whether hobbies should be encouraged in schools.', 'I strongly think so. Hobbies develop creativity, patience, and self-knowledge that academic subjects alone can\'t provide. A school that makes room for hobbies nurtures the whole person, not just the test-taker.', 'Argue with reasoning.', ['encourage', 'creativity', 'self-knowledge', 'whole person']],
            ['How might immersive technologies reshape hobbies?', 'VR could make expensive or dangerous hobbies — flying, sculpting, deep-sea diving — accessible to many. Whether they\'ll feel as satisfying as physical hobbies is an open question, but the range of possible hobbies will expand dramatically.', 'Speculate with examples.', ['immersive', 'accessible', 'satisfying', 'expand']],
        ],
    ],

    // ============================================================
    // 7. EDUCATION (extra)
    // ============================================================
    'education' => [
        'A1' => [
            ['Do you like reading?', 'Yes, I like reading. I read story books. My favourite book is about animals.', 'Say yes/no + what you read.', ['reading', 'story book', 'animal', 'favourite']],
            ['What is your favourite subject?', 'My favourite subject is art. I like to draw and paint. The teacher is kind.', 'Name the subject + why.', ['subject', 'art', 'draw', 'paint']],
            ['Do you have homework today?', 'Yes, I have homework today. I have maths and English. I will do it after dinner.', 'Say yes/no + which subjects.', ['homework', 'maths', 'English', 'dinner']],
            ['Is your school big?', 'Yes, my school is big. It has many classrooms and a big field. I like my school.', 'Describe your school + 1 detail.', ['big', 'classroom', 'field', 'school']],
        ],
        'A2' => [
            ['What do you like most about school?', 'I like my friends the most. We play together at break time. I also like art class because I can be creative.', 'Mention 2 things you like.', ['friend', 'break time', 'art class', 'creative']],
            ['Do you think homework is useful?', 'Yes, I think homework is useful because it helps me remember what I learned. But too much homework makes me tired.', 'Give an opinion + a condition.', ['useful', 'remember', 'learn', 'tired']],
            ['Talk about a teacher you remember well.', 'I remember my English teacher, Mr. Adi. He was funny and kind. He made us laugh while we learned, and he never got angry.', 'Describe the teacher + why memorable.', ['remember', 'funny', 'kind', 'angry']],
            ['Would you like to study abroad?', 'Yes, I would like to study abroad. I want to see new places and meet people from other countries. But I would miss my family.', 'Express desire + a worry.', ['study abroad', 'new place', 'miss', 'family']],
        ],
        'B1' => [
            ['How do you prefer to learn — by reading, listening, or doing?', 'I learn best by doing. Reading gives me theory, but I only truly understand something when I apply it. Projects and practical exercises stick with me far longer than lectures.', 'Identify your style + reason.', ['theory', 'apply', 'project', 'stick']],
            ['Do you think grades motivate students?', 'Grades motivate in the short term, but often for the wrong reasons — to beat others or avoid punishment. I think intrinsic motivation, like genuine curiosity, leads to deeper learning that lasts.', 'Distinguish extrinsic vs intrinsic.', ['grade', 'motivate', 'curiosity', 'intrinsic']],
            ['Describe a subject that changed how you think.', 'Studying philosophy changed how I think. It taught me to question assumptions and argue carefully. I started seeing everyday disagreements as problems to analyse rather than win.', 'Explain a shift in thinking.', ['philosophy', 'assumption', 'argue', 'analyse']],
            ['Should education focus more on practical skills?', 'I think there should be a better balance. Academic knowledge gives you breadth, but practical skills — financial literacy, communication, coding — prepare you for real life. Both matter, and schools often neglect the second.', 'Argue for balance.', ['practical skill', 'financial literacy', 'communication', 'neglect']],
        ],
        'B2' => [
            ['"The mind is not a vessel to be filled but a fire to be kindled." Discuss.', 'I strongly agree. Education that treats students as containers produces passive learners who forget quickly. Kindling curiosity, by contrast, creates lifelong learners who seek knowledge themselves. The teacher\'s role is closer to a fire-lighter than a filler.', 'Engage with the metaphor.', ['vessel', 'kindle', 'passive', 'lifelong']],
            ['How should education adapt to a world where information is free?', 'If facts are free, education must shift from transmitting them to evaluating, synthesising, and applying them. Critical thinking, ethics, and collaboration become more important than memorisation. The challenge is that these are harder to teach and to assess.', 'Argue for a skills shift.', ['transmit', 'evaluate', 'synthesise', 'assess']],
            ['Discuss whether standardised testing does more harm than good.', 'I lean towards more harm. Standardised tests narrow the curriculum, reward test-taking skill over understanding, and create stress that harms learning. They\'re efficient for systems but often poor for students, though alternatives are harder to design at scale.', 'Take a stance with nuance.', ['standardised', 'narrow', 'test-taking', 'at scale']],
            ['How might lifelong learning reshape adulthood?', 'I think the idea of education ending at twenty will fade. As careers change faster, adults will return to learning repeatedly. This could make life more interesting and flexible, but it also demands affordable access and a culture that values older learners.', 'Speculate on cultural shift.', ['lifelong learning', 'adulthood', 'affordable', 'value']],
        ],
    ],

    // ============================================================
    // 8. TECHNOLOGY (extra)
    // ============================================================
    'technology' => [
        'A1' => [
            ['Do you have a computer?', 'Yes, I have a computer. I use it for school. I play games on it too.', 'Say yes/no + 2 uses.', ['computer', 'school', 'game', 'use']],
            ['Do you like robots?', 'Yes, I like robots. They are cool. I want a robot that cleans my room.', 'Say yes/no + what you want.', ['robot', 'cool', 'clean', 'want']],
            ['What do you watch on TV?', 'I watch cartoons on TV. My father watches the news. I like funny cartoons.', 'Say what you + someone else watches.', ['TV', 'cartoon', 'news', 'funny']],
            ['Can you use a phone?', 'Yes, I can use a phone. I call my mom. I play games on it.', 'Say yes/no + 2 things you do.', ['phone', 'call', 'game', 'mom']],
        ],
        'A2' => [
            ['How do you use the internet for school?', 'I use the internet to search for information and to watch educational videos. I also send my homework to my teacher by email. It is very helpful.', 'List 2–3 uses.', ['search', 'video', 'email', 'helpful']],
            ['Do you think children should have phones?', 'I think older children can have phones, but with rules. They should not use phones during meals or before bed. Parents should check what their children do online.', 'Express a conditional opinion.', ['rule', 'meal', 'bed', 'online']],
            ['Talk about a gadget you want to buy.', 'I want to buy wireless earbuds. They are useful for listening to music and for online classes. I am saving my money to buy them.', 'Describe the gadget + why.', ['wireless earbuds', 'music', 'online class', 'save']],
            ['Is technology good or bad for children?', 'I think technology is both good and bad. It helps children learn, but too much screen time is bad for their eyes and sleep. Balance is important.', 'Weigh both sides.', ['good', 'bad', 'screen time', 'balance']],
        ],
        'B1' => [
            ['How do you protect your privacy online?', 'I use strong, unique passwords and two-factor authentication. I\'m careful about what I share publicly, and I review app permissions regularly. No single step is perfect, but together they reduce the risk.', 'List concrete practices.', ['privacy', 'password', 'two-factor', 'permission']],
            ['Describe a time technology failed you.', 'My laptop crashed the night before a major deadline, and I hadn\'t backed up my work. I learned the hard way to save constantly and use cloud backups. The panic taught me more than any lecture could.', 'Use narrative + lesson.', ['crash', 'deadline', 'back up', 'panic']],
            ['Do you think social media makes people lonely?', 'Sometimes, yes. Social media offers the illusion of connection without the depth. I\'ve noticed I feel lonelier after scrolling than after a single real conversation. Used mindfully it can connect, but used mindlessly it isolates.', 'Express a nuanced view.', ['illusion', 'connection', 'mindful', 'isolate']],
            ['How has technology changed your study habits?', 'Online courses and apps have made learning far more flexible — I can study anything, anytime. But the same devices bring constant distraction, so I\'ve had to build discipline around them. Technology amplifies whatever habits I bring to it.', 'Weigh benefits and drawbacks.', ['flexible', 'distraction', 'discipline', 'amplify']],
        ],
        'B2' => [
            ['"Technology is neither good nor bad; nor is it neutral." Discuss.', 'I think this captures it perfectly. Technology\'s effects depend on its design and use, but it\'s never neutral — it always shapes behaviour in particular directions. The honest question isn\'t whether tech is good, but whose interests a given technology serves.', 'Engage with the quotation.', ['neutral', 'shape', 'behaviour', 'serve']],
            ['How should society regulate AI without stifling innovation?', 'I think the key is targeted, principle-based regulation rather than blanket rules. Requiring transparency for high-risk applications, auditing for bias, and clear liability for harm would allow innovation while protecting people. The challenge is enforcement across borders.', 'Propose a balanced approach.', ['regulate', 'stifle', 'transparency', 'liability']],
            ['Discuss the digital divide and its long-term consequences.', 'The digital divide isn\'t just about devices — it\'s about skills, access, and confidence. As more of life moves online, those without access fall further behind in education, work, and even healthcare. I think closing it is one of the defining equity issues of our time.', 'Frame as an equity issue.', ['digital divide', 'access', 'equity', 'fall behind']],
            ['How might brain-computer interfaces change what it means to learn?', 'If we could download skills or communicate thought-to-thought, learning would shift from effortful acquisition to instant transfer. This sounds liberating, but I worry it could hollow out the struggle that makes learning meaningful. Ease and depth don\'t always go together.', 'Speculate philosophically.', ['brain-computer interface', 'acquisition', 'transfer', 'hollow out']],
        ],
    ],

    // ============================================================
    // 9. HEALTH & WELLNESS (extra)
    // ============================================================
    'health-wellness' => [
        'A1' => [
            ['Do you drink water every day?', 'Yes, I drink water every day. I drink six glasses. Water is good for me.', 'Say yes/no + how much.', ['water', 'glass', 'every day', 'good']],
            ['What sport do you like?', 'I like badminton. I play with my brother. It is fun and fast.', 'Name a sport + who you play with.', ['sport', 'badminton', 'brother', 'fast']],
            ['Do you eat vegetables?', 'Yes, I eat vegetables. I like carrots and spinach. My mother cooks them.', 'Say yes/no + 2 vegetables.', ['vegetable', 'carrot', 'spinach', 'cook']],
            ['What do you do when you are tired?', 'When I am tired, I sleep. Sometimes I drink warm milk. I rest on the sofa.', 'Describe 2 things you do.', ['tired', 'sleep', 'warm milk', 'rest']],
        ],
        'A2' => [
            ['How do you stay healthy in winter?', 'In winter I wear warm clothes and drink warm tea. I try to sleep early and eat lots of fruit. I also wash my hands often to avoid getting sick.', 'List 3 winter habits.', ['winter', 'warm', 'fruit', 'wash hands']],
            ['Do you think breakfast is important?', 'Yes, I think breakfast is very important. It gives me energy for the morning. If I skip it, I feel tired and hungry at school.', 'Give an opinion + a reason.', ['breakfast', 'energy', 'skip', 'hungry']],
            ['Talk about a time you were sick.', 'Last month I had a bad cold. I stayed in bed for two days. My mother made me soup and I slept a lot. I felt better by the third day.', 'Use past tense + how you recovered.', ['sick', 'cold', 'soup', 'recover']],
            ['What do you do to relax?', 'To relax I listen to calm music and take deep breaths. Sometimes I walk in the park. A warm shower also helps me feel calm.', 'List 2–3 relaxation methods.', ['relax', 'calm music', 'deep breath', 'park']],
        ],
        'B1' => [
            ['How do you stay active when you\'re busy?', 'I build movement into my day — taking stairs, walking to the shops, stretching between tasks. Short workouts at home work better for me than trying to find time for the gym. Consistency beats intensity.', 'Describe a realistic strategy.', ['active', 'stair', 'stretch', 'consistency']],
            ['Do you think mental health is talked about enough now?', 'More than before, but there\'s still a gap between awareness and support. People are more open, yet services are often underfunded and hard to access. I think we\'ve started an important conversation that society still needs to catch up with.', 'Acknowledge progress + gaps.', ['awareness', 'support', 'underfunded', 'catch up']],
            ['Describe a healthy change you\'ve made and how it affected you.', 'I started sleeping eight hours instead of six, and the change was striking. I think more clearly, my mood is steadier, and I get sick less often. It made me realise how much I\'d normalised running on too little sleep.', 'Use before/after contrast.', ['sleep', 'mood', 'steadier', 'normalise']],
            ['Should employers do more to support employee health?', 'I think so, though it benefits them too. Long hours and constant connectivity burn people out, which costs companies in the long run. Reasonable hours, mental health support, and respect for time off are investments, not perks.', 'Argue with mutual benefit.', ['employer', 'connectivity', 'burn out', 'investment']],
        ],
        'B2' => [
            ['"Health is not just the absence of illness." Discuss.', 'I strongly agree. The World Health Organization defines health as complete physical, mental, and social well-being, which is far broader than "not sick". This broader view matters because someone can be disease-free yet deeply unwell in other ways.', 'Engage with the definition.', ['absence', 'well-being', 'disease-free', 'broader']],
            ['How should societies address the rise in lifestyle diseases?', 'It needs both individual and structural action. Sugar taxes, walkable cities, and healthier school meals shape the environment, while education helps people make better choices. Blaming individuals alone ignores how much our environment shapes what we eat and how we move.', 'Argue for structural solutions.', ['lifestyle disease', 'sugar tax', 'walkable', 'environment']],
            ['Discuss the line between self-care and self-indulgence.', 'I think the line is about intention and effect. True self-care restores you for what matters; self-indulgence offers short-term comfort but leaves you worse off. The wellness industry often blurs the two, selling indulgence as care, which is why discernment matters.', 'Distinguish two concepts.', ['self-care', 'self-indulgence', 'restore', 'discernment']],
            ['How might wearable health tech change medicine?', 'Wearables could catch problems early and personalise treatment, which is genuinely exciting. But they also risk pathologising normal variation and turning health into constant surveillance. The technology is powerful; the wisdom to use it well lags behind.', 'Speculate with caution.', ['wearable', 'pathologise', 'surveillance', 'wisdom']],
        ],
    ],

    // ============================================================
    // 10. CULTURE & ARTS (extra)
    // ============================================================
    'culture-arts' => [
        'A1' => [
            ['Do you like drawing?', 'Yes, I like drawing. I draw flowers and houses. I use many colours.', 'Say yes/no + what you draw.', ['draw', 'flower', 'house', 'colour']],
            ['What music do you like?', 'I like pop music. It is happy and fast. I dance to it in my room.', 'Name a music style + why.', ['pop music', 'happy', 'fast', 'dance']],
            ['Do you have a favourite book?', 'Yes, my favourite book is a story about a dog. The dog is brave. I read it many times.', 'Describe the book + why.', ['book', 'story', 'dog', 'brave']],
            ['What festival do you like?', 'I like New Year. We eat special food. We watch fireworks. It is exciting.', 'Name a festival + 2 activities.', ['festival', 'New Year', 'fireworks', 'exciting']],
        ],
        'A2' => [
            ['Describe a film you enjoyed recently.', 'I watched a film about a young musician. The music was beautiful and the story was moving. I almost cried at the end.', 'Describe plot + feelings.', ['film', 'musician', 'moving', 'cry']],
            ['Do you prefer reading books or watching films?', 'I prefer films because they are quicker and the pictures are beautiful. But books let me imagine the characters, which is also special.', 'State preference + reason.', ['prefer', 'film', 'book', 'imagine']],
            ['Talk about a tradition in your culture.', 'In my culture, we celebrate Eid with prayers and special food. We visit relatives and give money to children. It is a happy time.', 'Describe the tradition + activities.', ['tradition', 'Eid', 'prayer', 'relative']],
            ['Have you ever been to a concert?', 'Yes, I went to a pop concert last year. The music was very loud and the crowd was excited. I sang along to every song.', 'Use past tense + describe it.', ['concert', 'loud', 'crowd', 'sing along']],
        ],
        'B1' => [
            ['How does art enrich everyday life?', 'Art turns ordinary moments into something meaningful — a song that captures a feeling, a painting that changes how you see a street. Without art, life functions but feels flatter. I think art is what makes daily life feel worth living, not just endured.', 'Argue for art\'s everyday value.', ['enrich', 'capture', 'flat', 'worth living']],
            ['Describe a book or film that changed your perspective.', 'A documentary about climate change reshaped how I see everyday choices. Seeing the scale of the problem viscerally, not just as facts, turned vague concern into genuine commitment. I changed habits afterwards.', 'Use narrative + reflection.', ['documentary', 'viscerally', 'concern', 'commitment']],
            ['Do you think traditional arts are dying out?', 'Some are struggling, but others are being reinvented by young artists who blend old forms with new ideas. The threat is real, but so is the creativity of those keeping traditions alive in fresh ways. I\'m cautiously optimistic.', 'Acknowledge threat + adaptation.', ['reinvent', 'blend', 'threat', 'cautiously']],
            ['Should the government fund the arts?', 'I believe so. The arts enrich society but often can\'t survive on profit alone. Public funding lets risky, experimental work exist and makes culture accessible to everyone, not just those who can pay. It\'s an investment in the public imagination.', 'Argue with reasoning.', ['fund', 'experimental', 'accessible', 'imagination']],
        ],
        'B2' => [
            ['"Art is a lie that makes us realise truth." Discuss.', 'I think Picasso\'s line captures art\'s strange power. By inventing rather than recording, art reveals patterns and truths that literal description misses. A novel can be truer than a memoir about what it feels like to be human.', 'Engage with the paradox.', ['lie', 'literal', 'pattern', 'true']],
            ['How does globalisation affect local cultures?', 'It cuts both ways. Global media can drown out local voices, but it also lets local artists reach global audiences. The cultures that thrive are those that engage with the world without losing themselves — easier said than done.', 'Present the dual effect.', ['globalisation', 'drown out', 'thrive', 'engage']],
            ['Discuss whether art can drive social change.', 'I think it can, indirectly but powerfully. Art doesn\'t pass laws, but it shifts how people feel, and feelings drive political change. A photograph or a song can make an abstract injustice viscerally real in a way statistics never could.', 'Argue for art\'s indirect power.', ['social change', 'shift', 'injustice', 'statistics']],
            ['Can AI-generated work be considered art?', 'I find it genuinely contested. If art requires human intention, AI output is more imitation than art. But if art is judged by its effect on the viewer, some AI work clearly moves people. The question is evolving faster than our definitions.', 'Hold an open, evolving stance.', ['intention', 'imitation', 'effect', 'evolving']],
        ],
    ],

    // ============================================================
    // 11. ENVIRONMENT & NATURE (extra)
    // ============================================================
    'environment-nature' => [
        'A1' => [
            ['Do you like the sun?', 'Yes, I like the sun. It is warm and bright. I play outside on sunny days.', 'Say yes/no + why.', ['sun', 'warm', 'bright', 'outside']],
            ['What animals can you see at the zoo?', 'I can see lions, monkeys, and elephants at the zoo. The monkeys are very funny.', 'Name 3 animals + 1 detail.', ['zoo', 'lion', 'monkey', 'elephant']],
            ['Do you like flowers?', 'Yes, I like flowers. They are colourful and smell nice. My mother has flowers in the garden.', 'Say yes/no + 2 details.', ['flower', 'colourful', 'smell', 'garden']],
            ['Is it hot or cold today?', 'Today is hot. The sun is strong. I drink a lot of water.', 'Describe the weather + what you do.', ['hot', 'cold', 'sun', 'water']],
        ],
        'A2' => [
            ['What can you do to save water at home?', 'I can turn off the tap when I brush my teeth. I can take shorter showers. We also reuse water for the plants.', 'List 2–3 water-saving habits.', ['save water', 'tap', 'shower', 'reuse']],
            ['Describe a season in your country.', 'In the rainy season it rains every afternoon. The streets get wet and the air is cool. I like the sound of the rain on the roof.', 'Mention the season + characteristics.', ['season', 'rainy', 'street', 'roof']],
            ['Do you think pollution is a big problem?', 'Yes, I think pollution is a big problem. The air in cities is dirty and the rivers are sometimes full of rubbish. It makes people sick.', 'Express an opinion + examples.', ['pollution', 'dirty', 'rubbish', 'sick']],
            ['Talk about a pet or animal you care about.', 'I care about my cat, Mimi. I feed her twice a day and play with her. She is part of our family.', 'Describe the animal + what you do.', ['care about', 'feed', 'play', 'family']],
        ],
        'B1' => [
            ['How can individuals reduce their carbon footprint?', 'Individuals can fly less, eat less meat, and buy fewer disposable goods. No single action solves the problem, but together they reduce demand and signal to companies and governments that change is wanted.', 'List actions + their wider effect.', ['carbon footprint', 'disposable', 'demand', 'signal']],
            ['Describe a natural place that is special to you.', 'A small beach near my hometown is special to me. As a child I collected shells there with my grandmother. It\'s quieter now, but the smell of the sea still makes me feel completely at peace.', 'Use sensory + emotional detail.', ['beach', 'shell', 'sea', 'at peace']],
            ['Do you think eco-tourism helps or harms nature?', 'It can help by giving local communities a reason to protect wildlife, but it can also harm if it brings too many visitors to fragile places. Done carefully, with limits and local control, it can be a genuine force for good.', 'Weigh both sides + a condition.', ['eco-tourism', 'fragile', 'local control', 'force for good']],
            ['What environmental issue do you think is most overlooked?', 'I think soil degradation is hugely overlooked. We talk about air and oceans, but the loss of healthy soil threatens food security quietly. By the time it\'s visible, recovery takes generations.', 'Identify an under-discussed issue.', ['soil degradation', 'overlooked', 'food security', 'recovery']],
        ],
        'B2' => [
            ['"We do not inherit the earth from our ancestors; we borrow it from our children." Discuss.', 'I find this framing powerful because it reframes environmental responsibility as a loan, not a gift. It challenges the idea that resources are ours to use up. Whether it actually changes behaviour is another question, but as an ethical compass it\'s compelling.', 'Engage with the ethical framing.', ['inherit', 'borrow', 'reframe', 'compass']],
            ['How should the world balance development and conservation?', 'It\'s a genuine tension. Poor countries need development to lift people out of poverty, but unchecked development destroys the ecosystems we all depend on. I think the answer is sustainable development — growth that restores rather than depletes, funded in part by wealthier nations.', 'Frame as a global tension.', ['development', 'conservation', 'sustainable', 'deplete']],
            ['Discuss the role of indigenous knowledge in conservation.', 'Indigenous communities have managed ecosystems sustainably for centuries, often far better than modern conservation has. I think recognising their land rights and learning from their practices isn\'t just just — it\'s one of the most effective conservation strategies we have.', 'Argue for recognition + effectiveness.', ['indigenous', 'sustainably', 'land rights', 'conservation']],
            ['How might climate change reshape where people live?', 'I expect a slow but enormous shift. Some coastal cities may become unlivable, while northern regions could become more hospitable. The transitions will be politically fraught, with climate refugees testing borders. Planning now could ease what waiting will make painful.', 'Speculate on migration patterns.', ['unlivable', 'hospitable', 'climate refugee', 'planning']],
        ],
    ],

    // ============================================================
    // 12. DREAMS & GOALS (extra)
    // ============================================================
    'dreams-goals' => [
        'A1' => [
            ['What do you want to do this weekend?', 'This weekend I want to play with my friends. I also want to eat pizza. It will be fun.', 'Use "I want to" + 2 things.', ['weekend', 'friend', 'pizza', 'fun']],
            ['Do you want to travel?', 'Yes, I want to travel to Japan. I want to see the temples. I want to eat sushi.', 'Say yes/no + where + why.', ['travel', 'Japan', 'temple', 'sushi']],
            ['What makes you proud?', 'I am proud when I help my mother. I am proud when I get good marks at school.', 'Use "I am proud when..." + 2 examples.', ['proud', 'help', 'mark', 'school']],
            ['Do you have a small dream?', 'Yes, my small dream is to have a bicycle. I want to ride it to the park with my friends.', 'Describe a small dream + why.', ['small dream', 'bicycle', 'ride', 'park']],
        ],
        'A2' => [
            ['What is a goal you have for this year?', 'My goal for this year is to improve my English. I will practise every day and watch English films. I want to speak more confidently.', 'State the goal + your plan.', ['goal', 'improve', 'practise', 'confidently']],
            ['How do you celebrate when you reach a goal?', 'When I reach a goal I tell my family and we go out for dinner. I also give myself a small reward, like a new book. Celebrating keeps me motivated.', 'Describe your celebration + why.', ['celebrate', 'reach', 'reward', 'motivated']],
            ['Talk about a goal you did not achieve.', 'I wanted to learn the guitar last year, but I gave up after a month. It was harder than I expected, and I did not have enough time. I want to try again this year.', 'Use past tense + why it failed.', ['achieve', 'give up', 'hard', 'try again']],
            ['Who supports you in your dreams?', 'My parents support me the most. They encourage me and help me when things are hard. My best friend also believes in me.', 'Mention who + how.', ['support', 'encourage', 'believe in', 'hard']],
        ],
        'B1' => [
            ['How do you stay motivated when progress is slow?', 'I focus on the process rather than the outcome, and I track small wins. When results are slow, the daily habit itself becomes the reward. Reminding myself why I started also helps me keep going.', 'Describe a mindset strategy.', ['motivated', 'process', 'outcome', 'habit']],
            ['Describe a goal that took longer than you expected.', 'Learning a second language has taken far longer than I imagined. There were long plateaus where I felt stuck. Looking back, those plateaus were actually when the deepest learning was happening.', 'Use narrative + reflection.', ['plateau', 'stuck', 'deepest', 'happen']],
            ['Do you think it\'s important to share your goals with others?', 'It depends. Sharing with the right people creates accountability and support, but sharing too widely can create a false sense of achievement. I share selectively, with people who\'ll push me, not just cheer.', 'Express a nuanced view.', ['accountability', 'achievement', 'selectively', 'push']],
            ['What is a goal you have that you haven\'t told many people about?', 'I quietly want to write a book one day. I haven\'t told many people because the idea still feels fragile. I\'m collecting notes and small pieces, waiting until it feels ready to take seriously.', 'Use vulnerable, reflective tone.', ['quietly', 'fragile', 'collect', 'take seriously']],
        ],
        'B2' => [
            ['"The journey is more important than the destination." Discuss.', 'I mostly agree. The destination gives direction, but the journey shapes who you become. Someone who reaches a goal through shortcuts is different from someone who reaches it through struggle — even if the outcome looks identical.', 'Engage with the quotation.', ['destination', 'direction', 'shortcut', 'struggle']],
            ['How should society define "success" beyond wealth and status?', 'I think we need a broader definition that includes relationships, well-being, contribution, and growth. A society that only celebrates wealth narrows what people feel they can strive for. Redefining success could redirect enormous human energy toward more fulfilling pursuits.', 'Argue for a broader definition.', ['status', 'well-being', 'contribution', 'strive']],
            ['Discuss the role of privilege in achieving one\'s dreams.', 'Privilege doesn\'t guarantee success, but it removes obstacles that others face. Acknowledging this doesn\'t diminish hard work — it simply keeps us honest. I think those who\'ve succeeded despite obstacles deserve extra credit, and those who\'ve had help should remember it.', 'Engage honestly with privilege.', ['privilege', 'obstacle', 'diminish', 'honest']],
            ['How do you know when to persist and when to let go of a goal?', 'I ask whether the goal still aligns with who I am becoming. If the reasons have changed but I\'m persisting out of habit or ego, it\'s time to let go. If the goal still feels meaningful but the method isn\'t working, I persist but adjust the approach.', 'Describe a decision framework.', ['persist', 'align', 'ego', 'adjust']],
        ],
    ],

];
