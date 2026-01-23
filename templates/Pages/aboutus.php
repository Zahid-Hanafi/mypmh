<div class="max-w-5xl mx-auto">
    <div class="relative rounded-3xl overflow-hidden mb-12 shadow-2xl h-80 flex items-center justify-center">
        <div class="absolute inset-0 bg-pmh-purple opacity-90"></div>
        <div class="relative text-center p-10">
            <h1 class="text-5xl font-black text-pmh-yellow uppercase tracking-tighter mb-4">Persatuan Mahasiswa Hadhari</h1>
            <p class="text-white text-lg max-w-2xl mx-auto italic">Nurturing Excellence, Heritage, and Integrity among UiTM Students.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
        <div class="space-y-6">
            <h2 class="text-3xl font-bold text-pmh-purple border-b-4 border-pmh-yellow inline-block">Our History</h2>
            <p class="text-gray-600 leading-relaxed">Persatuan Mahasiswa Hadhari (PMH) was established at UiTM Puncak Perdana to bridge the gap between academic excellence and spiritual heritage. We focus on organizing programs that empower students with leadership skills while maintaining the core values of Hadhari philosophy.</p>
            
            <div class="bg-gray-100 p-6 rounded-2xl border-l-4 border-pmh-purple">
                <h4 class="font-bold mb-2 uppercase text-xs text-pmh-purple">Download Official Profile</h4>
                <p class="text-sm text-gray-500 mb-4">View our full history, organizational chart, and annual achievement report in PDF format.</p>
                <a href="#" class="inline-flex items-center gap-2 bg-pmh-purple text-white px-6 py-2 rounded-xl font-bold hover:bg-black transition-all">
                    <i class="fas fa-file-pdf"></i> PMH Achievements.pdf
                </a>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <h2 class="text-3xl font-bold text-pmh-purple mb-6">Student Reviews</h2>
            <div class="space-y-6">
                <div class="border-b pb-4">
                    <p class="text-gray-600 italic">"Joining PMH was the best decision of my university life. The community is supportive and the programs are very impactful!"</p>
                    <p class="font-bold mt-2 text-pmh-purple">— Ahmad Zaki, Semester 4</p>
                </div>
                <div class="border-b pb-4">
                    <p class="text-gray-600 italic">"I love the Ivory Edition T-shirts! The quality is amazing and it feels great to represent the association."</p>
                    <p class="font-bold mt-2 text-pmh-purple">— Siti Sarah, Semester 2</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-pmh-yellow rounded-3xl p-10 text-center shadow-xl">
        <h3 class="text-3xl font-black text-pmh-purple mb-4">Interested in joining our family?</h3>
        <p class="text-purple-900 mb-8 font-medium">Be part of the change and develop your potential with us.</p>
        <a href="<?= $this->Url->build(['controller' => 'Applications', 'action' => 'joinus']) ?>" class="bg-pmh-purple text-white px-12 py-4 rounded-2xl font-black text-xl hover:scale-105 transition-transform inline-block shadow-lg">JOIN PMH NOW</a>
    </div>
</div>