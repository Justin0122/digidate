<div>
    <div
        x-data="{
            open: false,
            search: '',
            input: '🙂',
            emojis: {
                'tractor, farm, machine, agriculture': '🚜',
                'leaf, plant, nature, green, agricultre, ecology': '🌿',
                'corn, field, agricuultre, vegetable, plant, nature, green, ecology': '🌽',
                'fish, sea, ocan, swimming, water': '🐟',
                'home, house, building, apartment, residence': '🏠',
                'university, official, building, columns, institution': '🏦',
                'school, education, student, learn, diploma': '🏫',
                'education, school, student, learn, diploma': '🎓',
                'child, children, young': '🧒',
                'book, paper, knowledge, reading, library, books, literature': '📖',
                'scroll, paper, document, page, book': '📜',
                'contract, bookmark, tab, sheet, signature': '📑',
                'pencil, write, edit, paper, memo, note': '✏️',
                'pen, write, paper, memo, note, fountain pen': '✒️',
                'military, army, soldier, war, helmet': '🪖',
                'tool, measure, scale, ruler, law, regulation, enforcement': '⚖️',
                'police, cop, urgence, security, law, enforcement, arrest, criminal, law enforcement': '🚓',
                'shield, protection, security, safety, defense': '🛡️',
                'urgence, police, fire, light, warning, danger': '🚨',
                'bomb, explode, explosion, bang, blast, grenade': '💣',
                'fire, flame, hot, heat, blaze, brigade': '🔥',
                'thermometer, hot, temperature, warm, ill, illness, fever': '🌡️',
                'money, bag, dollar, coin': '💰',
                'money, purse, wallet, bag, dollar, euro': '👛',
                'credit, bank, money, loan, bill, payment, credit card': '💶',
                'chart, graph, analytics, statistics, data, report': '📊',
                'money, dollar, currency, payment, bank, banknote, exchange, cash': '💱',
                'money, dollar, currency, payment, bank, banknote, exchange, cash': '💵',
                'money, dollar, currency, payment, bank, banknote, exchange, cash, fly': '💸',
                'shopping, buy, purchase, cart, buy': '🛒',
                'shopping, buy, purchase, shopping cart': '🛍️',
                'travel, luggage, bag, suitcase, bag': '🧳',
                'film, movie, motion, cinema, theater, culture': '🎬',
                'computer, laptop, digital, keyboard, monitor, screen': '💻',
                'lightning, bolt, electricity, science': '⚡',
                'light, bulb, electric, electricity': '💡',
                'flashlight, light, lamp': '🔦',
                'rocket, launch, space, ship, plane, space, start up': '🚀',
                'hospital, medical, center, care, health, sickness, disease, illness': '🏥',
                'clothing, lab, coat, science, laboratory': '🥼',
                'factory, building, manufacturing, production, construction, polution': '🏭',
                'globe, world, earth, planet, map, travel, space': '🌍',
                'location, map, pin, marker, navigation, aid': '📍',
                'europe, european union, flag, country, nation, place, location, geography, globe': '🇪🇺',
                'custom, border, control, security, safety, protection': '🛂',
                'bus, car, transportation, transportation vehicle, trolly': '🚎',
                'alarm, clock, morning, ring, wake up': '⏰',
                'clock, time, timer, watch, stopwatch': '⏱',
                'truck, transportation, delivery, road, vehicule': '🚚',
                'truck, transportation, delivery, road, vehicule': '🚛',
                'key, lock, password, secure': '🔑',
                'trophy, award, cup, competition, game, sport, winner': '🏆',
                'win, medal, gold, silver, bronze, rank, trophy, sport, competition, game, award': '🏅',
                'flex, muscle, body, workout, exercise': '💪',
                'congratulations, party, popper, confetti, celebration': '🎉',
                'ticket, prize, gift, award, prize, gift, admission': '🎟',
                'star, gold, yellow, sky, space, night, evening, dusk': '⭐️',
                'star, astronomy, sparkle, sparkles, magic': '✨',
                'heart, like, favorite, love': '❤️',
                'handshake, agreement, hands': '🤝‍',
                'eye, vision, look, see': '👀',
                'megaphone, announcement, broadcast, public, speaking': '📣',
                'dice, game, chance, roll, random, target, center': '🎯',
                'gift, present, package, box, celebrate, birthday, party': '🎁',
                'balloon, celebration,party, birthday,': '🎈',
                'hourglass, time, timer, watch, stopwatch': '⏳',
                'clap, applause, bravo, hand, gesture, wave, hand clapping': '👏',
                'clown, face, funny, lol, party, hat': '🥳',
                'face, happy, joy, heart, love, emotion, smiley': '🥰',
                'sunglasses, cool, smile, smiley': '😎',
                'laughing, lol, smile, smiley': '😂',
                'open hands, smiley, hug, love, care': '🤗',
                'smiley, face, happy, joy, emotion, smiley': '🙂',
                'smirk, face, smile, emotion, smiley': '😏',
                'wink, face, smile, emotion, smiley': '😉',
                'kiss, face, love, like, affection, valentine': '😘',
                'middle finger, hand, finger, rude, gesture, insult': '🖕',
                'thumbs up, hand, finger, like, agree, accept, ok, yes': '👍',
                'thumbs down, hand, finger, dislike, disagree, refuse, no': '👎',
                'ok, hand, finger, agree, accept, yes, good, success, approve, correct': '👌',
            },
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            },
            get filteredEmojis() {
                return Object.keys(this.emojis)
                .filter(key => key.includes(this.search))
                .reduce((obj, key) => {
                  obj[key] = this.emojis[key];
                  return obj;
                }, {})
            }
        }"
        x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['dropdown-button']"
        class="relative"
    >
        <!-- Button -->
        <button
            x-ref="button"
            x-on:click="toggle()"
            :aria-expanded="open"
            :aria-controls="$id('dropdown-button')"
            type="button"
            class="bg-white px-5 py-2.5 rounded-md shadow border dark:bg-gray-800 dark:border-gray-700 mx-1"
        >
            <span x-text="input"></span>
        </button>

        <input type="hidden" id="emoji" x-model="input" value="">
        <div
            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            style="display: none; width: 24.85rem; bottom: 100%;"
            class="absolute left-0 mt-2 p-4 max-h-64 bg-white shadow-md overflow-scroll rounded border dark:bg-gray-800 dark:border-gray-700"
        >
            <x-input type="search" x-model="search" class="w-full"
                     placeholder="Search an emoji..." autofocus/>
            <template x-for="(emoji, keywords) in filteredEmojis" :key="emoji">
                <button id="emote-button" wire:click="addEmote(emoji)"
                        class="inline-block py-2 px-3 m-1 cursor-pointer rounded-md bg-gray-100 hover:bg-blue-100 dark:bg-gray-800 dark:hover:bg-blue-800"
                        :title="keywords" x-on:click="input = emoji; toggle();">
                    <span class="inline-block w-5 h-5" x-text="emoji"></span>
                </button>
            </template>
        </div>
    </div>
</div>
